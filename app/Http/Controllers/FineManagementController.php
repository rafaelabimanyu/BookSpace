<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FineManagementController extends Controller
{
    /**
     * Display global fines ledger.
     */
    public function index()
    {
        // Load overdue checkouts and checkouts with existing fine balances
        $borrowings = Borrowing::with(['user', 'book'])
            ->where(function ($query) {
                $query->where('status', 'borrowed')
                      ->where('return_date', '<', date('Y-m-d'));
            })
            ->orWhere('fine_amount', '>', 0)
            ->latest()
            ->get();

        $dailyFineRate = (double)Setting::get('daily_fine_rate', 1000);
        $durationDays = (int)Setting::get('default_borrow_duration', 7);

        $borrowings->transform(function ($borrowing) use ($dailyFineRate, $durationDays) {
            if ($borrowing->status === 'borrowed') {
                $today = now()->startOfDay();
                $deadline = \Illuminate\Support\Carbon::parse($borrowing->return_date)->startOfDay();
                
                if ($today->gt($deadline)) {
                    $daysLate = abs($today->diffInDays($deadline));
                    $borrowing->calculated_fine = $daysLate * $dailyFineRate;
                    $borrowing->days_late = $daysLate;
                } else {
                    $borrowing->calculated_fine = 0;
                    $borrowing->days_late = 0;
                }
            } else {
                $borrowing->calculated_fine = $borrowing->fine_amount;
                
                // Calculate actual returned late days
                $deadline = \Illuminate\Support\Carbon::parse($borrowing->created_at)->addDays($durationDays)->startOfDay();
                $actualReturn = \Illuminate\Support\Carbon::parse($borrowing->return_date)->startOfDay();
                
                if ($actualReturn->gt($deadline)) {
                    $borrowing->days_late = abs($actualReturn->diffInDays($deadline));
                } else {
                    $borrowing->days_late = 0;
                }
            }
            return $borrowing;
        });

        return view('management.fines', compact('borrowings'));
    }

    /**
     * Verify payment status inside a secure database transaction.
     */
    public function verifyPayment(Borrowing $borrowing)
    {
        $dailyFineRate = (double)Setting::get('daily_fine_rate', 1000);
        $durationDays = (int)Setting::get('default_borrow_duration', 7);
        $fineAmount = $borrowing->fine_amount;

        if ($borrowing->status === 'borrowed') {
            $today = now()->startOfDay();
            $deadline = \Illuminate\Support\Carbon::parse($borrowing->return_date)->startOfDay();
            if ($today->gt($deadline)) {
                $daysLate = abs($today->diffInDays($deadline));
                $fineAmount = $daysLate * $dailyFineRate;
            }
        } else {
            if ($fineAmount <= 0) {
                $deadline = \Illuminate\Support\Carbon::parse($borrowing->created_at)->addDays($durationDays)->startOfDay();
                $actualReturn = \Illuminate\Support\Carbon::parse($borrowing->return_date)->startOfDay();
                if ($actualReturn->gt($deadline)) {
                    $daysLate = abs($actualReturn->diffInDays($deadline));
                    $fineAmount = $daysLate * $dailyFineRate;
                }
            }
        }

        try {
            DB::transaction(function () use ($borrowing, $fineAmount) {
                $borrowing->update([
                    'fine_amount' => $fineAmount,
                    'fine_status' => 'paid',
                ]);
            });

            // Localized success message containing borrower and book name
            $message = __('Fine payment verified successfully for borrower :name and book ":title"!', [
                'name' => $borrowing->user->name,
                'title' => $borrowing->book->title,
            ]);

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', __('An error occurred while verifying the fine payment.'));
        }
    }
}

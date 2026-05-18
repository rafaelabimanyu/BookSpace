<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display configuration board.
     */
    public function index()
    {
        $maxBooksAllowed = (int)Setting::get('max_books_allowed', 3);
        $defaultBorrowDuration = (int)Setting::get('default_borrow_duration', 7);
        $dailyFineRate = (double)Setting::get('daily_fine_rate', 1000);

        return view('management.settings', compact('maxBooksAllowed', 'defaultBorrowDuration', 'dailyFineRate'));
    }

    /**
     * Settle validation checks and update configs in the database registry.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'max_books_allowed' => 'required|integer|min:1|max:50',
            'default_borrow_duration' => 'required|integer|min:1|max:365',
            'daily_fine_rate' => 'required|numeric|min:0',
        ]);

        Setting::set('max_books_allowed', (string)$validated['max_books_allowed']);
        Setting::set('default_borrow_duration', (string)$validated['default_borrow_duration']);
        Setting::set('daily_fine_rate', (string)$validated['daily_fine_rate']);

        return back()->with('success', __('System configurations updated successfully!'));
    }
}

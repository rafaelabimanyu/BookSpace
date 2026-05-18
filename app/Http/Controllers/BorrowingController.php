<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use App\Http\Requests\StoreBorrowingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->latest()->get();
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $users = User::where('role', 'peminjam')->get();
        $books = Book::all(); // Load all books to demonstrate zero-stock validation error if selected
        return view('borrowings.create', compact('users', 'books'));
    }

    public function store(StoreBorrowingRequest $request)
    {
        $validated = $request->validated();
        $borrowDate = $validated['borrow_date'];
        $returnDate = !empty($validated['return_date']) ? $validated['return_date'] : date('Y-m-d', strtotime($borrowDate . ' +7 days'));

        // DB Transaction for stock checking and safety
        try {
            DB::beginTransaction();

            $book = Book::lockForUpdate()->findOrFail($request->book_id);

            if ($book->stock <= 0) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', __('This book is currently out of stock!'));
            }

            Borrowing::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'borrow_date' => $borrowDate,
                'return_date' => $returnDate,
                'status' => 'borrowed',
            ]);

            $book->decrement('stock');

            DB::commit();

            return redirect()->route('borrowings.index')->with('success', __('Borrowing recorded successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', __('An error occurred while processing the borrowing transaction.'));
        }
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return redirect()->back()->with('error', __('This book has already been returned.'));
        }

        try {
            DB::beginTransaction();

            $borrowing->update([
                'status' => 'returned',
                'return_date' => date('Y-m-d'), // set actual return date to today
            ]);

            $borrowing->book->increment('stock');

            DB::commit();

            return redirect()->route('borrowings.index')->with('success', __('Book returned successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('An error occurred while processing the return transaction.'));
        }
    }
}

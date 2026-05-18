<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowerCatalogController extends Controller
{
    public function catalog(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');

        $query = Book::with(['category', 'reviews.user']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('writer', 'like', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $books = $query->latest()->get();
        $categories = Category::all();

        return view('peminjam.catalog', compact('books', 'categories', 'search', 'categoryId'));
    }

    public function history()
    {
        $borrowings = auth()->user()->borrowings()->with('book')->latest()->get();
        return view('peminjam.history', compact('borrowings'));
    }

    public function reserveBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $bookId = $request->input('book_id');
        $userId = auth()->user()->id;

        $book = Book::find($bookId);

        // Security guards
        if ($book->stock <= 0) {
            return back()->with('error', __('This book is currently out of stock!'));
        }

        // Check if the user is already borrowing an active copy of this exact book
        $alreadyBorrowed = Borrowing::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('status', 'borrowed')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', __('You are already borrowing this book!'));
        }

        // Database transaction
        try {
            DB::transaction(function () use ($book, $userId) {
                Borrowing::create([
                    'user_id' => $userId,
                    'book_id' => $book->id,
                    'borrow_date' => now(),
                    'return_date' => now()->addDays(7),
                    'status' => 'borrowed',
                ]);

                $book->decrement('stock');
            });

            return back()->with('success', __('Successfully reserved!'));
        } catch (\Exception $e) {
            return back()->with('error', __('An error occurred while processing the borrowing transaction.'));
        }
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $userId = auth()->user()->id;
        $bookId = $request->input('book_id');

        // Security: ensure the user has actually borrowed and returned the book at least once.
        $hasReturned = Borrowing::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('status', 'returned')
            ->exists();

        if (!$hasReturned) {
            return back()->with('error', __('You can only review books you have borrowed and returned.'));
        }

        // Save or update the review
        Review::updateOrCreate(
            ['user_id' => $userId, 'book_id' => $bookId],
            [
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]
        );

        return back()->with('success', __('Thank you for your review!'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\Review;
use App\Http\Requests\ReserveBookRequest;
use App\Http\Requests\StoreReviewRequest;
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

    public function reserveBook(ReserveBookRequest $request)
    {
        $validated = $request->validated();
        $bookId = $validated['book_id'];
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

    public function storeReview(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        $userId = auth()->user()->id;
        $bookId = $validated['book_id'];

        // Save or update the review
        Review::updateOrCreate(
            ['user_id' => $userId, 'book_id' => $bookId],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        return back()->with('success', __('Thank you for your review!'));
    }
}

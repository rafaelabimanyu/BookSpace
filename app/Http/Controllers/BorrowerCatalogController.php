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
use App\Models\Setting;

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

        // Check dynamic checkout limit
        $activeBorrowingsCount = Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->count();
        $maxBooksAllowed = (int)Setting::get('max_books_allowed', 3);

        if ($activeBorrowingsCount >= $maxBooksAllowed) {
            return back()->with('error', __('You have reached the maximum borrow limit of :limit books!', ['limit' => $maxBooksAllowed]));
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
            $durationDays = (int)Setting::get('default_borrow_duration', 7);
            DB::transaction(function () use ($book, $userId, $durationDays) {
                Borrowing::create([
                    'user_id' => $userId,
                    'book_id' => $book->id,
                    'borrow_date' => now(),
                    'return_date' => now()->addDays($durationDays),
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

    public function showBook(Book $book)
    {
        $book->load(['category', 'reviews.user']);
        return view('peminjam.show', compact('book'));
    }

    public function wishlist()
    {
        $books = auth()->user()->wishlistedBooks()->with('category')->latest()->get();
        return view('peminjam.wishlist', compact('books'));
    }

    public function toggleWishlist(Request $request)
    {
        $bookId = $request->input('book_id');
        $user = auth()->user();
        
        $res = $user->wishlistedBooks()->toggle($bookId);
        $message = !empty($res['attached']) ? __('Added to Wishlist!') : __('Removed from Wishlist!');

        return back()->with('success', $message);
    }

    public function profile()
    {
        $user = auth()->user();
        return view('peminjam.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Ensure the directory exists
            $dir = public_path('uploads/profiles');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            
            $file->move($dir, $filename);
            $validated['profile_picture'] = 'uploads/profiles/' . $filename;
        }

        $user->update($validated);

        return redirect()->back()->with('success', __('Profile updated successfully!'));
    }

    public function fines()
    {
        $borrowings = auth()->user()->borrowings()->with('book')->latest()->get();
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

        return view('peminjam.fines', compact('borrowings'));
    }

    public function payFine(Borrowing $borrowing)
    {
        // Calculate the fine if active, otherwise use persisted denda
        $fineAmount = $borrowing->fine_amount;
        $dailyFineRate = (double)Setting::get('daily_fine_rate', 1000);
        $durationDays = (int)Setting::get('default_borrow_duration', 7);
        
        if ($borrowing->status === 'borrowed') {
            $today = now()->startOfDay();
            $deadline = \Illuminate\Support\Carbon::parse($borrowing->return_date)->startOfDay();
            
            if ($today->gt($deadline)) {
                $daysLate = abs($today->diffInDays($deadline));
                $fineAmount = $daysLate * $dailyFineRate;
            }
        } else {
            // Persisted
            if ($fineAmount <= 0) {
                // Check if they returned late and have unpaid fine
                $deadline = \Illuminate\Support\Carbon::parse($borrowing->created_at)->addDays($durationDays)->startOfDay();
                $actualReturn = \Illuminate\Support\Carbon::parse($borrowing->return_date)->startOfDay();
                
                if ($actualReturn->gt($deadline)) {
                    $daysLate = abs($actualReturn->diffInDays($deadline));
                    $fineAmount = $daysLate * $dailyFineRate;
                }
            }
        }

        $borrowing->update([
            'fine_amount' => $fineAmount,
            'fine_status' => 'paid',
        ]);

        return redirect()->back()->with('success', __('Fine paid successfully!'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'peminjam') {
            // Borrower stats
            $activeBorrowingsCount = $user->borrowings()->where('status', 'borrowed')->count();
            $totalBorrowingsCount = $user->borrowings()->count();
            $nearestDeadlineBorrowing = $user->borrowings()
                ->where('status', 'borrowed')
                ->orderBy('return_date', 'asc')
                ->first();
            $recommendations = Book::with('category')
                ->where('stock', '>', 0)
                ->inRandomOrder()
                ->take(4)
                ->get();

            return view('dashboard', compact(
                'activeBorrowingsCount',
                'totalBorrowingsCount',
                'nearestDeadlineBorrowing',
                'recommendations'
            ));
        } else {
            // Staff / Admin stats
            $staffTotalBooks = Book::count();
            $staffActiveBorrowings = Borrowing::where('status', 'borrowed')->count();
            $staffOverdueBorrowings = Borrowing::where('status', 'borrowed')
                ->where('return_date', '<', date('Y-m-d'))
                ->count();

            // Fulfillment Rate (Rasio Pengembalian)
            $totalBorrowings = Borrowing::count();
            $returnedBorrowings = Borrowing::where('status', 'returned')->count();
            $fulfillmentRate = $totalBorrowings > 0 
                ? round(($returnedBorrowings / $totalBorrowings) * 100, 1) 
                : 100;

            // Category Popularity Grid: count borrowings per category
            $categories = Category::all()->map(function ($category) {
                $borrowCount = Borrowing::whereHas('book', function ($q) use ($category) {
                    $q->where('category_id', $category->id);
                })->count();
                $category->borrow_count = $borrowCount;
                return $category;
            });

            // Sort by popularity and take top 5
            $maxBorrowCount = $categories->max('borrow_count') ?: 1; // avoid division by zero
            $categoryPopularity = $categories->sortByDesc('borrow_count')
                ->values()
                ->take(5)
                ->map(function ($category) use ($maxBorrowCount) {
                    $category->percentage = round(($category->borrow_count / $maxBorrowCount) * 100);
                    return $category;
                });

            // Recent activity ledger
            $recentActivity = Borrowing::with(['user', 'book'])->latest()->take(5)->get();

            // Today's pending tasks count
            $pendingOverdueCount = Borrowing::where('status', 'borrowed')
                ->where('return_date', '<=', date('Y-m-d'))
                ->count();
            $outOfStockBooksCount = Book::where('stock', 0)->count();
            $pendingTasksCount = $pendingOverdueCount + $outOfStockBooksCount;

            // Form selection lists for Modals
            $borrowersList = User::where('role', 'peminjam')->orderBy('name')->get();
            $booksList = Book::where('stock', '>', 0)->orderBy('title')->get();
            $allCategoriesList = Category::orderBy('name')->get();

            return view('dashboard', compact(
                'staffTotalBooks',
                'staffActiveBorrowings',
                'staffOverdueBorrowings',
                'fulfillmentRate',
                'categoryPopularity',
                'recentActivity',
                'pendingOverdueCount',
                'outOfStockBooksCount',
                'pendingTasksCount',
                'borrowersList',
                'booksList',
                'allCategoriesList'
            ));
        }
    }
}

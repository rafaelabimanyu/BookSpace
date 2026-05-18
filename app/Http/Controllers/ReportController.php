<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $categoryId = $request->query('category_id');

        // Query borrowings with filters applied
        $query = Borrowing::with(['user', 'book.category']);

        if ($month) {
            $query->whereMonth('borrow_date', $month);
        }

        if ($year) {
            $query->whereYear('borrow_date', $year);
        }

        if ($categoryId) {
            $query->whereHas('book', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        $borrowings = $query->latest()->get();

        // Calculate General Metrics
        $totalBooksCount = Book::sum('stock');
        $totalBooksTitles = Book::count();
        
        $activeReadersCount = User::where('role', 'peminjam')
            ->whereHas('borrowings', function ($q) {
                $q->where('status', 'borrowed');
            })->count();

        $totalBorrowings = Borrowing::count();
        $returnedBorrowings = Borrowing::where('status', 'returned')->count();
        
        $fulfillmentRate = $totalBorrowings > 0 
            ? round(($returnedBorrowings / $totalBorrowings) * 100, 1) 
            : 100;

        $categories = Category::all();
        $yearsList = Borrowing::selectRaw('YEAR(borrow_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return view('admin.reports', compact(
            'borrowings',
            'totalBooksCount',
            'totalBooksTitles',
            'activeReadersCount',
            'fulfillmentRate',
            'categories',
            'yearsList',
            'month',
            'year',
            'categoryId'
        ));
    }
}

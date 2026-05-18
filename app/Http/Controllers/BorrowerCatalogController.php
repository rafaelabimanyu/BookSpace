<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BorrowerCatalogController extends Controller
{
    public function catalog(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');

        $query = Book::with('category');

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
}

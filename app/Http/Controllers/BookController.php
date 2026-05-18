<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'ISBN' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => __('Book title is required.'),
            'writer.required' => __('Writer is required.'),
            'publisher.required' => __('Publisher is required.'),
            'year.required' => __('Year is required.'),
            'ISBN.required' => __('ISBN is required.'),
            'stock.required' => __('Stock is required.'),
            'stock.min' => __('Stock cannot be negative.'),
            'category_id.required' => __('Category is required.'),
            'cover_image.max' => __('Cover image size must not exceed 2MB.'),
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', __('Book created successfully!'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'ISBN' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => __('Book title is required.'),
            'writer.required' => __('Writer is required.'),
            'publisher.required' => __('Publisher is required.'),
            'year.required' => __('Year is required.'),
            'ISBN.required' => __('ISBN is required.'),
            'stock.required' => __('Stock is required.'),
            'stock.min' => __('Stock cannot be negative.'),
            'category_id.required' => __('Category is required.'),
            'cover_image.max' => __('Cover image size must not exceed 2MB.'),
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', __('Book updated successfully!'));
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('books.index')->with('success', __('Book deleted successfully!'));
    }
}

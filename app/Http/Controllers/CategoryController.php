<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ], [
            'name.required' => __('Category name is required.'),
            'name.unique' => __('Category name has already been taken.'),
        ]);

        Category::create($request->only('name'));

        return redirect()->route('categories.index')->with('success', __('Category created successfully!'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ], [
            'name.required' => __('Category name is required.'),
            'name.unique' => __('Category name has already been taken.'),
        ]);

        $category->update($request->only('name'));

        return redirect()->route('categories.index')->with('success', __('Category updated successfully!'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', __('Category deleted successfully!'));
    }
}

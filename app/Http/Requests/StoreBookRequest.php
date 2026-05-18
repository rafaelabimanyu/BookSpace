<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'ISBN' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('Book title is required.'),
            'writer.required' => __('Writer is required.'),
            'publisher.required' => __('Publisher is required.'),
            'year.required' => __('Year is required.'),
            'ISBN.required' => __('ISBN is required.'),
            'stock.required' => __('Stock is required.'),
            'stock.min' => __('Stock cannot be negative.'),
            'category_id.required' => __('Category is required.'),
            'cover_image.max' => __('Cover image size must not exceed 2MB.'),
        ];
    }
}

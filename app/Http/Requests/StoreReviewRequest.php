<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                $userId = auth()->user()->id;
                $bookId = $this->input('book_id');

                $hasReturned = \App\Models\Borrowing::where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->where('status', 'returned')
                    ->exists();

                if (!$hasReturned) {
                    $validator->errors()->add('book_id', __('You can only review books you have borrowed and returned.'));
                }
            }
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => __('Book is required.'),
            'rating.required' => __('Rating is required.'),
            'rating.min' => __('Rating must be at least 1 star.'),
            'rating.max' => __('Rating cannot exceed 5 stars.'),
            'comment.required' => __('Comment is required.'),
        ];
    }
}

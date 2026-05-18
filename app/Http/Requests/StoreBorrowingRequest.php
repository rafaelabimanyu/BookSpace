<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after:borrow_date',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => __('Borrower is required.'),
            'book_id.required' => __('Book is required.'),
            'borrow_date.required' => __('Borrow date is required.'),
            'borrow_date.after_or_equal' => __('Borrow date cannot be in the past.'),
            'return_date.after' => __('Return date must be strictly after the borrow date.'),
        ];
    }
}

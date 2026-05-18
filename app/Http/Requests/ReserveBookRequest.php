<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => __('Book is required.'),
            'book_id.exists' => __('The selected book is invalid.'),
        ];
    }
}

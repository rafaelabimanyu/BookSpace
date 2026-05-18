<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:categories,name|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Category name is required.'),
            'name.unique' => __('Category name has already been taken.'),
        ];
    }
}

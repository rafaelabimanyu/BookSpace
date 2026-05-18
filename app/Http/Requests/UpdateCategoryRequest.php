<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id ?? $this->category;
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
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

@extends('layouts.bookspace')

@section('title', __('Edit Category'))

@section('header_title', __('Category Management'))

@section('content')
    <div class="max-w-xl mx-auto card p-6">
        <h2 class="text-2xl font-display font-bold mb-6 text-text-charcoal">{{ __('Edit Category') }}</h2>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="name" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Category Name') }}</label>
                <input type="text" name="name" id="name" class="input-field py-3 px-4 @error('name') border-red-400 focus:ring-red-400 @enderror" value="{{ old('name', $category->name) }}" placeholder="{{ __('Enter category name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('categories.index') }}" class="btn-secondary py-3 px-6 text-sm">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="btn-primary py-3 px-6 text-sm">
                    {{ __('Update Category') }}
                </button>
            </div>
        </form>
    </div>
@endsection

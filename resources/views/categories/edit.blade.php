@extends('layouts.bookspace')

@section('title', __('Edit Category'))

@section('header_title', __('Category Management'))

@section('content')
    <div class="max-w-xl mx-auto card p-6">
        <h2 class="text-2xl font-display font-bold mb-6 text-text-charcoal">{{ __('Edit Category') }}</h2>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" x-data="{ submitted: false }" @submit="submitted = true">
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
                <button type="submit" class="btn-primary py-3 px-6 text-sm flex items-center justify-center gap-2" :disabled="submitted" :class="submitted ? 'opacity-75 cursor-not-allowed bg-primary-rose/80' : ''">
                    <svg x-show="submitted" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="submitted ? '{{ __('Processing...') }}' : '{{ __('Update Category') }}'"></span>
                </button>
            </div>
        </form>
    </div>
@endsection

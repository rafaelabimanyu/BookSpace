@extends('layouts.bookspace')

@section('title', __('Add Book'))

@section('header_title', __('Book Management'))

@section('content')
    <div class="max-w-4xl mx-auto card p-8">
        <h2 class="text-2xl font-display font-bold mb-6 text-text-charcoal">{{ __('Add Book') }}</h2>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" x-data="{ submitted: false }" @submit="submitted = true">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Book Title -->
                <div class="mb-2">
                    <label for="title" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Book Title') }}</label>
                    <input type="text" name="title" id="title" class="input-field py-3 px-4 @error('title') border-red-400 focus:ring-red-400 @enderror" value="{{ old('title') }}" placeholder="{{ __('Enter book title') }}" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Writer -->
                <div class="mb-2">
                    <label for="writer" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Writer') }}</label>
                    <input type="text" name="writer" id="writer" class="input-field py-3 px-4 @error('writer') border-red-400 focus:ring-red-400 @enderror" value="{{ old('writer') }}" placeholder="{{ __('Enter writer name') }}" required>
                    @error('writer')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publisher -->
                <div class="mb-2">
                    <label for="publisher" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Publisher') }}</label>
                    <input type="text" name="publisher" id="publisher" class="input-field py-3 px-4 @error('publisher') border-red-400 focus:ring-red-400 @enderror" value="{{ old('publisher') }}" placeholder="{{ __('Enter publisher name') }}" required>
                    @error('publisher')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div class="mb-2">
                    <label for="year" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Year') }}</label>
                    <input type="number" name="year" id="year" class="input-field py-3 px-4 @error('year') border-red-400 focus:ring-red-400 @enderror" value="{{ old('year', date('Y')) }}" placeholder="{{ __('Enter published year') }}" min="1000" max="{{ date('Y') }}" required>
                    @error('year')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ISBN -->
                <div class="mb-2">
                    <label for="ISBN" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('ISBN') }}</label>
                    <input type="text" name="ISBN" id="ISBN" class="input-field py-3 px-4 @error('ISBN') border-red-400 focus:ring-red-400 @enderror" value="{{ old('ISBN') }}" placeholder="{{ __('Enter ISBN code') }}" required>
                    @error('ISBN')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="mb-2">
                    <label for="stock" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Stock') }}</label>
                    <input type="number" name="stock" id="stock" class="input-field py-3 px-4 @error('stock') border-red-400 focus:ring-red-400 @enderror" value="{{ old('stock', 1) }}" placeholder="{{ __('Enter stock inventory') }}" min="0" required>
                    @error('stock')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-2">
                    <label for="category_id" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Category') }}</label>
                    <select name="category_id" id="category_id" class="input-field py-3 px-4 @error('category_id') border-red-400 focus:ring-red-400 @enderror" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div class="mb-2">
                    <label for="cover_image" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Cover Image') }}</label>
                    <input type="file" name="cover_image" id="cover_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-secondary-blush file:text-primary-rose hover:file:bg-primary-rose hover:file:bg-white file:transition file:cursor-pointer cursor-pointer border border-secondary-blush/60 rounded-2xl p-2 bg-white" accept="image/*">
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('books.index') }}" class="btn-secondary py-3 px-6 text-sm">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="btn-primary py-3 px-6 text-sm flex items-center justify-center gap-2" :disabled="submitted" :class="submitted ? 'opacity-75 cursor-not-allowed bg-primary-rose/80' : ''">
                    <svg x-show="submitted" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="submitted ? '{{ __('Processing...') }}' : '{{ __('Add Book') }}'"></span>
                </button>
            </div>
        </form>
    </div>
@endsection

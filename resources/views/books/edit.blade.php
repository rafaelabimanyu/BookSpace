@extends('layouts.bookspace')

@section('title', __('Edit Book'))

@section('header_title', __('Book Management'))

@section('content')
    <div class="max-w-4xl mx-auto card p-8">
        <h2 class="text-2xl font-display font-bold mb-6 text-text-charcoal">{{ __('Edit Book') }}</h2>

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Cover Image Preview Column -->
                <div class="flex flex-col items-center justify-center p-6 bg-secondary-blush/20 rounded-3xl border border-secondary-blush/50">
                    <div class="mb-4 text-sm font-bold text-gray-500 font-display">{{ __('Cover Image') }}</div>
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-40 h-56 object-cover rounded-2xl shadow-md border border-secondary-blush mb-4">
                    @else
                        <div class="w-40 h-56 bg-secondary-blush rounded-2xl shadow-sm border border-secondary-blush/40 flex items-center justify-center text-primary-rose text-sm font-bold font-display mb-4">
                            No Cover
                        </div>
                    @endif
                    <input type="file" name="cover_image" id="cover_image" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-secondary-blush file:text-primary-rose hover:file:bg-primary-rose hover:file:text-white file:transition file:cursor-pointer cursor-pointer border border-secondary-blush/60 rounded-xl p-1 bg-white" accept="image/*">
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Inputs Columns -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Book Title -->
                    <div class="mb-2">
                        <label for="title" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Book Title') }}</label>
                        <input type="text" name="title" id="title" class="input-field py-3 px-4 @error('title') border-red-400 focus:ring-red-400 @enderror" value="{{ old('title', $book->title) }}" placeholder="{{ __('Enter book title') }}" required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Writer -->
                    <div class="mb-2">
                        <label for="writer" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Writer') }}</label>
                        <input type="text" name="writer" id="writer" class="input-field py-3 px-4 @error('writer') border-red-400 focus:ring-red-400 @enderror" value="{{ old('writer', $book->writer) }}" placeholder="{{ __('Enter writer name') }}" required>
                        @error('writer')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher -->
                    <div class="mb-2">
                        <label for="publisher" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Publisher') }}</label>
                        <input type="text" name="publisher" id="publisher" class="input-field py-3 px-4 @error('publisher') border-red-400 focus:ring-red-400 @enderror" value="{{ old('publisher', $book->publisher) }}" placeholder="{{ __('Enter publisher name') }}" required>
                        @error('publisher')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year -->
                    <div class="mb-2">
                        <label for="year" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Year') }}</label>
                        <input type="number" name="year" id="year" class="input-field py-3 px-4 @error('year') border-red-400 focus:ring-red-400 @enderror" value="{{ old('year', $book->year) }}" placeholder="{{ __('Enter published year') }}" min="1000" max="{{ date('Y') }}" required>
                        @error('year')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div class="mb-2">
                        <label for="ISBN" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('ISBN') }}</label>
                        <input type="text" name="ISBN" id="ISBN" class="input-field py-3 px-4 @error('ISBN') border-red-400 focus:ring-red-400 @enderror" value="{{ old('ISBN', $book->ISBN) }}" placeholder="{{ __('Enter ISBN code') }}" required>
                        @error('ISBN')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="mb-2">
                        <label for="stock" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Stock') }}</label>
                        <input type="number" name="stock" id="stock" class="input-field py-3 px-4 @error('stock') border-red-400 focus:ring-red-400 @enderror" value="{{ old('stock', $book->stock) }}" placeholder="{{ __('Enter stock inventory') }}" min="0" required>
                        @error('stock')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-2 md:col-span-2">
                        <label for="category_id" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Category') }}</label>
                        <select name="category_id" id="category_id" class="input-field py-3 px-4 @error('category_id') border-red-400 focus:ring-red-400 @enderror" required>
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('books.index') }}" class="btn-secondary py-3 px-6 text-sm">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="btn-primary py-3 px-6 text-sm">
                    {{ __('Update Book') }}
                </button>
            </div>
        </form>
    </div>
@endsection

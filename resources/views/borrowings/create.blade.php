@extends('layouts.bookspace')

@section('title', __('Record Borrowing'))

@section('header_title', __('Library Circulation'))

@section('content')
    <div class="max-w-2xl mx-auto card p-8">
        <h2 class="text-2xl font-display font-bold mb-6 text-text-charcoal">{{ __('Record Borrowing') }}</h2>

        <form action="{{ route('borrowings.store') }}" method="POST">
            @csrf

            <!-- Borrower (Peminjam) -->
            <div class="mb-5">
                <label for="user_id" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Borrower') }}</label>
                <select name="user_id" id="user_id" class="input-field py-3 px-4 @error('user_id') border-red-400 focus:ring-red-400 @enderror" required>
                    <option value="">{{ __('Select Borrower') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Book (Buku) -->
            <div class="mb-5">
                <label for="book_id" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Book Title') }}</label>
                <select name="book_id" id="book_id" class="input-field py-3 px-4 @error('book_id') border-red-400 focus:ring-red-400 @enderror" required>
                    <option value="">{{ __('Select Book') }}</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} ({{ __('Stock') }}: {{ $book->stock }})
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dates Group -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <!-- Borrow Date -->
                <div>
                    <label for="borrow_date" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Borrow Date') }}</label>
                    <input type="date" name="borrow_date" id="borrow_date" class="input-field py-3 px-4 @error('borrow_date') border-red-400 focus:ring-red-400 @enderror" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                    @error('borrow_date')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Return Date -->
                <div>
                    <label for="return_date" class="block font-semibold text-sm text-text-charcoal mb-2">
                        {{ __('Return Date') }} <span class="text-gray-400 text-xs font-normal">({{ __('Optional, default +7 days') }})</span>
                    </label>
                    <input type="date" name="return_date" id="return_date" class="input-field py-3 px-4 @error('return_date') border-red-400 focus:ring-red-400 @enderror" value="{{ old('return_date') }}">
                    @error('return_date')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('borrowings.index') }}" class="btn-secondary py-3 px-6 text-sm">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="btn-primary py-3 px-6 text-sm">
                    {{ __('Record Borrowing') }}
                </button>
            </div>
        </form>
    </div>
@endsection

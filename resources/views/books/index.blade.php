@extends('layouts.bookspace')

@section('title', __('Book Management'))

@section('header_title', __('Book Management'))

@section('content')
    <div class="card p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <h2 class="text-2xl font-display font-bold text-text-charcoal">{{ __('Books') }}</h2>
            <a href="{{ route('books.create') }}" class="btn-primary py-3 px-6 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Add Book') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-sm">
                        <th class="py-4 px-4 font-display">{{ __('Cover Image') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Book Title') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Writer') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Publisher') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Category') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Stock') }}</th>
                        <th class="py-4 px-4 font-display text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-blush/40 font-medium">
                    @forelse($books as $book)
                        <tr class="hover:bg-secondary-blush/10 transition">
                            <td class="py-4 px-4">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-14 h-20 object-cover rounded-xl shadow-sm border border-secondary-blush">
                                @else
                                    <div class="w-14 h-20 bg-secondary-blush rounded-xl shadow-sm border border-secondary-blush/40 flex items-center justify-center text-primary-rose text-xs font-bold font-display">
                                        No Cover
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-text-charcoal font-bold text-base">{{ $book->title }}</div>
                                <div class="text-gray-400 text-xs mt-1 font-semibold">ISBN: {{ $book->ISBN }} | {{ $book->year }}</div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">{{ $book->writer }}</td>
                            <td class="py-4 px-4 text-gray-600">{{ $book->publisher }}</td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-secondary-blush text-primary-rose text-xs font-bold rounded-xl border border-primary-rose/10">
                                    {{ $book->category->name }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($book->stock > 0)
                                    <span class="text-emerald-600 font-bold text-lg">{{ $book->stock }}</span>
                                @else
                                    <span class="px-2 py-1 bg-rose-50 text-rose-600 text-xs font-bold rounded-lg border border-rose-100">
                                        {{ __('Out of Stock') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right space-x-2">
                                <a href="{{ route('books.edit', $book->id) }}" class="inline-flex items-center px-3 py-1.5 bg-secondary-blush text-primary-rose rounded-xl text-xs font-bold hover:bg-primary-rose hover:text-white transition shadow-sm">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this book?') }}')" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold hover:bg-rose-600 hover:text-white transition shadow-sm">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400 font-medium">
                                {{ __('No books found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

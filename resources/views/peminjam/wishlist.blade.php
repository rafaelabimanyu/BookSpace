@extends('layouts.bookspace')

@section('title', __('My Wishlist'))

@section('header_title', __('My Wishlist'))

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <h2 class="text-2xl font-display font-bold text-text-charcoal mb-2">{{ __('My Saved Books') }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($books as $book)
                <div class="card overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col relative group">
                    <!-- Wishlist Toggle overlay -->
                    <div class="absolute top-3 right-3 z-10">
                        <form action="{{ route('peminjam.wishlist.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm border border-secondary-blush flex items-center justify-center shadow-sm text-primary-rose transition transform hover:scale-110 active:scale-95">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Glowing Stock Badge Overlay -->
                    @if($book->stock > 0)
                        <div class="absolute top-3 left-3 z-10">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-secondary-blush border border-primary-rose text-primary-rose rounded-2xl text-[10px] font-extrabold shadow-sm animate-pulse tracking-wide uppercase">
                                <span class="w-2 h-2 rounded-full bg-primary-rose"></span>
                                {{ __('Ready to Borrow!') }}
                            </span>
                        </div>
                    @endif

                    <!-- Cover -->
                    <div class="aspect-[3/4] bg-secondary-blush relative flex items-center justify-center overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="text-primary-rose font-display font-bold text-lg select-none">
                                {{ substr($book->title, 0, 3) }}
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="p-5 flex-1 flex flex-col justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold text-primary-rose uppercase tracking-wider">{{ $book->category->name }}</span>
                            <h3 class="font-display font-bold text-text-charcoal leading-tight group-hover:text-primary-rose transition-colors line-clamp-1">
                                <a href="{{ route('peminjam.books.show', $book->id) }}">{{ $book->title }}</a>
                            </h3>
                            <p class="text-xs text-text-charcoal/60">{{ __('by') }} <span class="font-semibold">{{ $book->writer }}</span></p>
                        </div>

                        <!-- Action Form with AlpineJS protection -->
                        <div x-data="{ submitting: false }">
                            @if($book->stock > 0)
                                <form action="{{ route('peminjam.borrow') }}" method="POST" @submit="submitting = true">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit" class="btn-primary w-full py-2.5 px-4 text-xs flex items-center justify-center gap-2" :disabled="submitting">
                                        <svg x-show="submitting" class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-text="submitting ? '{{ __('Processing...') }}' : '{{ __('Pinjam Buku') }}'"></span>
                                    </button>
                                </form>
                            @else
                                <button class="w-full bg-gray-100 text-gray-400 py-2.5 px-4 rounded-xl text-xs font-bold cursor-not-allowed border border-gray-200" disabled>
                                    {{ __('Out of Stock') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400">
                    <div class="inline-flex p-4 rounded-full bg-secondary-blush/60 text-primary-rose mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <p class="text-sm font-semibold text-text-charcoal/70">{{ __('Your wishlist is currently empty.') }}</p>
                    <a href="{{ route('peminjam.catalog') }}" class="btn-primary inline-flex py-2.5 px-6 text-xs mt-4">{{ __('Browse Books') }}</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection

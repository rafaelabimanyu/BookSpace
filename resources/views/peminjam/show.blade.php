@extends('layouts.bookspace')

@section('title', $book->title)

@section('header_title', __('Book Catalog'))

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">
        <!-- Back Button -->
        <a href="{{ route('peminjam.catalog') }}" class="inline-flex items-center gap-2 text-text-charcoal/60 hover:text-primary-rose transition-colors font-semibold text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ __('Back to Catalog') }}
        </a>

        <!-- Book Detail Card -->
        <div class="card p-8 md:p-12 flex flex-col md:flex-row gap-10 items-start">
            <!-- Left Side Cover -->
            <div class="w-full md:w-1/3 flex flex-col items-center gap-4">
                <div class="relative group rounded-3xl overflow-hidden shadow-md border-4 border-white/60 aspect-[3/4] w-full max-w-[280px]">
                    @if($book->cover_image)
                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-secondary-blush flex items-center justify-center text-primary-rose font-display font-bold text-lg">
                            {{ substr($book->title, 0, 3) }}
                        </div>
                    @endif
                    
                    <!-- Stock Badge Overlay -->
                    <div class="absolute top-4 right-4">
                        @if($book->stock > 0)
                            <span class="bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-2xl text-xs font-bold shadow-sm uppercase tracking-wider">
                                {{ __('Available') }} ({{ $book->stock }})
                            </span>
                        @else
                            <span class="bg-rose-100 text-rose-500 px-3 py-1.5 rounded-2xl text-xs font-bold shadow-sm uppercase tracking-wider">
                                {{ __('Out of Stock') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Action Form Buttons with AlpineJS protection -->
                <div class="w-full max-w-[280px] space-y-3 mt-4" x-data="{ submitting: false }">
                    @if($book->stock > 0)
                        <form action="{{ route('peminjam.borrow') }}" method="POST" @submit="submitting = true">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="btn-primary w-full py-3 px-6 text-sm flex items-center justify-center gap-2" :disabled="submitting">
                                <svg x-show="submitting" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <svg x-show="!submitting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span x-text="submitting ? '{{ __('Processing...') }}' : '{{ __('Pinjam Buku') }}'"></span>
                            </button>
                        </form>
                    @endif

                    <!-- Wishlist Toggle Button -->
                    <form action="{{ route('peminjam.wishlist.toggle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-2xl font-bold transition shadow-sm border border-secondary-blush bg-white text-text-charcoal hover:bg-rose-50/50 hover:text-primary-rose">
                            @if(auth()->user()->wishlistedBooks->contains($book->id))
                                <svg class="w-4 h-4 text-primary-rose fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                <span>{{ __('Saved') }}</span>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span>{{ __('Add to Wishlist') }}</span>
                            @endif
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side Details -->
            <div class="flex-1 space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-primary-rose bg-secondary-blush/60 px-3 py-1 rounded-xl">
                        {{ $book->category->name }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-display font-bold text-text-charcoal mt-3 tracking-tight">{{ $book->title }}</h1>
                    <p class="text-sm font-semibold text-text-charcoal/60 mt-1">
                        {{ __('by') }} <span class="text-primary-rose">{{ $book->writer }}</span>
                    </p>
                </div>

                <!-- Meta Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-secondary-blush/30 border border-secondary-blush p-4 rounded-2xl">
                        <span class="block text-[10px] uppercase font-bold text-text-charcoal/40">{{ __('Publisher') }}</span>
                        <span class="block text-sm font-bold text-text-charcoal/80 mt-1">{{ $book->publisher }}</span>
                    </div>
                    <div class="bg-secondary-blush/30 border border-secondary-blush p-4 rounded-2xl">
                        <span class="block text-[10px] uppercase font-bold text-text-charcoal/40">{{ __('Year') }}</span>
                        <span class="block text-sm font-bold text-text-charcoal/80 mt-1">{{ $book->year }}</span>
                    </div>
                    <div class="bg-secondary-blush/30 border border-secondary-blush p-4 rounded-2xl col-span-2 md:col-span-1">
                        <span class="block text-[10px] uppercase font-bold text-text-charcoal/40">{{ __('ISBN') }}</span>
                        <span class="block text-sm font-bold text-text-charcoal/80 mt-1">{{ $book->ISBN }}</span>
                    </div>
                </div>

                <!-- Rating summary -->
                @php
                    $avgRating = round($book->reviews->avg('rating'), 1);
                    $totalReviews = $book->reviews->count();
                @endphp
                <div class="flex items-center gap-2 border-y border-secondary-blush py-3">
                    <div class="flex text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $avgRating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-text-charcoal/80">{{ $avgRating > 0 ? $avgRating : '0.0' }}</span>
                    <span class="text-xs font-semibold text-text-charcoal/50">({{ $totalReviews }} {{ __('reviews') }})</span>
                </div>

                <!-- Synopsis -->
                <div>
                    <h3 class="font-display font-bold text-text-charcoal mb-2">{{ __('Synopsis') }}</h3>
                    <p class="text-sm text-text-charcoal/70 leading-relaxed">
                        {{ $book->synopsis ?? __('No synopsis available for this book.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Public Review Feed / Timeline -->
        <div class="card p-8 md:p-12">
            <h2 class="text-xl font-display font-bold mb-6 text-text-charcoal flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.9 1.9 0 01-2-2v-3"></path></svg>
                {{ __('Public Reviews Timeline') }}
            </h2>

            <div class="space-y-6">
                @forelse($book->reviews as $review)
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-secondary-blush/20 border border-secondary-blush/35 transition hover:shadow-sm">
                        <!-- Profile Pic -->
                        <div class="flex-shrink-0">
                            @if($review->user->profile_picture)
                                <img src="{{ asset($review->user->profile_picture) }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-primary-rose/50 shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-full bg-primary-rose/30 flex items-center justify-center text-primary-rose font-bold text-sm border-2 border-primary-rose/50">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <!-- Review Info -->
                        <div class="flex-1 space-y-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <h4 class="text-sm font-bold text-text-charcoal">{{ $review->user->name }}</h4>
                                <span class="text-[10px] text-text-charcoal/50 font-semibold">{{ $review->updated_at->diffForHumans() }}</span>
                            </div>
                            <!-- Stars -->
                            <div class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <!-- Comment -->
                            <p class="text-xs text-text-charcoal/70 leading-relaxed mt-1">
                                {{ $review->comment }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-text-charcoal/50">
                        <div class="inline-flex p-4 rounded-full bg-secondary-blush/60 text-primary-rose mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <p class="text-sm font-semibold text-text-charcoal/60">{{ __('Be the first to share your thoughts on this book!') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

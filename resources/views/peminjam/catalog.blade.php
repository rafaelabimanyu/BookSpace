@extends('layouts.bookspace')

@section('title', __('Book Catalog'))

@section('header_title', __('Book Catalog'))

@section('content')
    <!-- Search and Filter Section -->
    <div class="card p-6 mb-8 bg-white/95 border border-secondary-blush/60 shadow-sm">
        <form action="{{ route('peminjam.catalog') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            <!-- Search Input -->
            <div class="relative w-full md:flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="{{ __('Search book title or writer...') }}" class="input-field py-3 pl-12 pr-4 bg-bg-cream/40 border-secondary-blush/80 focus:bg-white transition text-sm">
            </div>

            <!-- Category Filter Dropdown -->
            <div class="w-full md:w-64">
                <select name="category_id" class="input-field py-3 px-4 bg-bg-cream/40 border-secondary-blush/80 focus:bg-white transition text-sm">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="btn-primary py-3 px-6 text-sm flex-1 md:flex-initial">
                    {{ __('Filter') }}
                </button>
                @if($search || $categoryId)
                    <a href="{{ route('peminjam.catalog') }}" class="btn-secondary py-3 px-6 text-sm text-center flex-1 md:flex-initial">
                        {{ __('Cancel') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Book Grid Catalog -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($books as $book)
            <div class="card p-4 flex flex-col bg-white border border-secondary-blush/40 hover:shadow-lg transition-premium hover:scale-[1.03] relative overflow-hidden" x-data="{ showReviews: false }">
                <!-- Cover Image Frame -->
                <div class="relative w-full aspect-[3/4] mb-4 bg-secondary-blush/20 rounded-2xl overflow-hidden border border-secondary-blush/20">
                    <!-- Wishlist Toggle overlay -->
                    <div class="absolute top-3 right-3 z-10">
                        <form action="{{ route('peminjam.wishlist.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm border border-secondary-blush flex items-center justify-center shadow-sm text-primary-rose transition transform hover:scale-110 active:scale-95">
                                @if(auth()->user()->wishlistedBooks->contains($book->id))
                                    <svg class="w-4 h-4 fill-current text-primary-rose" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                @else
                                    <svg class="w-4 h-4 stroke-current fill-none text-primary-rose" stroke-width="2" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                @endif
                            </button>
                        </form>
                    </div>

                    @if($book->cover_image)
                        <img src="{{ Str::startsWith($book->cover_image, 'http') ? $book->cover_image : (Str::startsWith($book->cover_image, 'uploads') ? asset($book->cover_image) : asset('storage/' . $book->cover_image)) }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-2xl transition-premium hover:scale-110">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-primary-rose">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="text-xs font-bold font-display uppercase tracking-wide">No Cover</span>
                        </div>
                    @endif

                    <!-- Category Badge Overlaid -->
                    <span class="absolute top-3 left-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-primary-rose text-[10px] font-bold uppercase tracking-wider rounded-xl shadow-sm border border-secondary-blush/60">
                        {{ $book->category->name }}
                    </span>
                </div>

                <!-- Book Metadata -->
                <div class="flex-1 flex flex-col">
                    <h3 class="text-lg font-display font-bold text-text-charcoal leading-tight mb-1 truncate hover:text-primary-rose transition-colors" title="{{ $book->title }}">
                        <a href="{{ route('peminjam.books.show', $book->id) }}">{{ $book->title }}</a>
                    </h3>
                    <p class="text-gray-500 font-medium text-xs mb-3">
                        {{ __('by') }} <span class="font-semibold text-gray-700">{{ $book->writer }}</span>
                    </p>

                    <!-- Rating Summary with slide-up trigger -->
                    @php
                        $reviewsCount = $book->reviews->count();
                        $averageRating = $reviewsCount > 0 ? round($book->reviews->avg('rating'), 1) : 0;
                    @endphp
                    <div class="flex items-center justify-between mb-4 text-xs font-semibold">
                        <div class="flex items-center gap-1">
                            <span class="text-amber-400">★</span>
                            <span class="text-text-charcoal font-bold">{{ $averageRating }}</span>
                            <span class="text-gray-400">({{ $reviewsCount }})</span>
                        </div>
                        @if($reviewsCount > 0)
                            <button @click="showReviews = true" class="text-primary-rose hover:underline font-bold text-[11px] flex items-center gap-0.5">
                                {{ __('View Reviews') }}
                            </button>
                        @endif
                    </div>
                    
                    <div class="mt-auto pt-3 border-t border-secondary-blush/40 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <!-- Stock Status -->
                            @if($book->stock > 0)
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wide">
                                        {{ __('Available') }} ({{ $book->stock }})
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 bg-rose-400 rounded-full"></span>
                                    <span class="text-xs font-bold text-rose-500 uppercase tracking-wide">
                                        {{ __('Out of Stock') }}
                                    </span>
                                </div>
                            @endif

                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                {{ $book->year }}
                            </span>
                        </div>

                        <!-- Reservation Button / Action Form -->
                        @if($book->stock > 0)
                            <form action="{{ route('peminjam.borrow') }}" method="POST" x-data="{ loading: false }" @submit="loading = true" class="w-full mt-1">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button 
                                    type="submit" 
                                    :disabled="loading" 
                                    class="btn-primary w-full py-2.5 px-4 text-xs flex items-center justify-center gap-2 transition duration-300 font-bold rounded-xl"
                                    :class="loading ? 'opacity-75 cursor-not-allowed bg-primary-rose/80' : ''"
                                >
                                    <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-text="loading ? '{{ __('Processing...') }}' : '{{ __('Pinjam Buku') }}'"></span>
                                </button>
                            </form>
                        @else
                            <button 
                                disabled 
                                class="w-full py-2.5 px-4 text-xs font-bold bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed text-center mt-1 border border-gray-200"
                            >
                                {{ __('Out of Stock') }}
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Slide-up Reviews Drawer overlay inside the card context -->
                @if($reviewsCount > 0)
                    <div 
                        x-show="showReviews"
                        x-transition:enter="transition-premium transform"
                        x-transition:enter-start="translate-y-full opacity-0"
                        x-transition:enter-end="translate-y-0 opacity-100"
                        x-transition:leave="transition-premium transform"
                        x-transition:leave-start="translate-y-0 opacity-100"
                        x-transition:leave-end="translate-y-full opacity-0"
                        class="absolute inset-0 bg-white/95 backdrop-blur-sm z-30 p-4 border border-secondary-blush/60 rounded-2xl flex flex-col justify-between"
                        style="display: none;"
                    >
                        <div class="flex justify-between items-center pb-2 border-b border-secondary-blush/40">
                            <h4 class="font-display font-bold text-sm text-text-charcoal">{{ __('User Reviews') }}</h4>
                            <button @click="showReviews = false" class="text-gray-400 hover:text-text-charcoal p-1 rounded-lg hover:bg-secondary-blush/40">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="space-y-3 flex-1 overflow-y-auto my-3 pr-1">
                            @foreach($book->reviews as $review)
                                <div class="bg-secondary-blush/20 border border-secondary-blush/40 p-2.5 rounded-xl text-left">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-bold text-[11px] text-text-charcoal truncate max-w-[120px]">{{ $review->user->name }}</span>
                                        <div class="flex text-[9px] text-amber-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-600 text-[10px] leading-snug line-clamp-3" title="{{ $review->comment }}">{{ $review->comment }}</p>
                                    <span class="text-[8px] text-gray-400 block text-right mt-1">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <button 
                            @click="showReviews = false" 
                            class="btn-secondary w-full py-2 text-xs font-bold rounded-xl"
                        >
                            {{ __('Close') }}
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full card p-12 text-center text-gray-400 font-medium">
                <svg class="w-16 h-16 text-secondary-blush mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('No books found matching your criteria.') }}
            </div>
        @endforelse
    </div>
@endsection

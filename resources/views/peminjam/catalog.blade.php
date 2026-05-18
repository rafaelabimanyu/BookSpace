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
            <div class="card p-4 flex flex-col bg-white border border-secondary-blush/40 hover:shadow-md transition duration-300 transform hover:-translate-y-1">
                <!-- Cover Image Frame -->
                <div class="relative w-full aspect-[3/4] mb-4 bg-secondary-blush/20 rounded-2xl overflow-hidden border border-secondary-blush/20">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-2xl transition duration-300 hover:scale-105">
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
                    <h3 class="text-lg font-display font-bold text-text-charcoal leading-tight mb-1 truncate" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>
                    <p class="text-gray-500 font-medium text-xs mb-3">
                        {{ __('by') }} <span class="font-semibold text-gray-700">{{ $book->writer }}</span>
                    </p>
                    
                    <div class="mt-auto pt-3 border-t border-secondary-blush/40 flex items-center justify-between">
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
                </div>
            </div>
        @empty
            <div class="col-span-full card p-12 text-center text-gray-400 font-medium">
                <svg class="w-16 h-16 text-secondary-blush mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('No books found matching your criteria.') }}
            </div>
        @endforelse
    </div>
@endsection

@extends('layouts.bookspace')

@section('title', __('Dashboard'))

@section('header_title')
    {{ __('Hello') }}, {{ auth()->user()->name }}
@endsection

@section('content')
    @php
        // Borrower stats queries
        $activeBorrowingsCount = auth()->user()->borrowings()->where('status', 'borrowed')->count();
        $totalBorrowingsCount = auth()->user()->borrowings()->count();
        $nearestDeadlineBorrowing = auth()->user()->borrowings()->where('status', 'borrowed')->orderBy('return_date', 'asc')->first();
        $recommendations = \App\Models\Book::with('category')->where('stock', '>', 0)->inRandomOrder()->take(4)->get();
        
        // Staff/Admin stats queries
        $staffTotalBooks = \App\Models\Book::count();
        $staffActiveBorrowings = \App\Models\Borrowing::where('status', 'borrowed')->count();
        $staffOverdueBorrowings = \App\Models\Borrowing::where('status', 'borrowed')->where('return_date', '<', date('Y-m-d'))->count();
    @endphp

    @if(auth()->user()->role === 'peminjam')
        <!-- ================= PEMINJAM (BORROWER) SPACE ================= -->
        <div class="animate-fadeIn space-y-8">
            
            <!-- Welcoming Animated Hero Section -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-primary-rose to-secondary-blush p-8 md:p-12 shadow-md text-text-charcoal border border-white/20">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/20 rounded-full blur-3xl filter opacity-80 animate-pulse"></div>
                <div class="relative z-10 max-w-xl">
                    <h2 class="text-3xl md:text-5xl font-display font-bold mb-4 tracking-wide text-text-charcoal animate-slideUp">
                        {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}
                    </h2>
                    <p class="text-sm md:text-base font-semibold text-text-charcoal/80 mb-6 leading-relaxed">
                        {{ __('"A room without books is like a body without a soul." Let\'s find your next favorite book today in the library!') }}
                    </p>
                    <a href="{{ route('peminjam.catalog') }}" class="btn-primary py-3 px-8 text-sm inline-flex items-center gap-2 transform hover:scale-105 hover:shadow-lg transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        {{ __('Search Book Catalog') }}
                    </a>
                </div>
            </div>

            <!-- Asymmetrical Grid with stats and timeline -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Quick Stats Reader Cards (Left/Center columns) -->
                <div class="lg:col-span-2 space-y-6">
                    <h3 class="text-xl font-display font-bold text-text-charcoal">{{ __('My Reading Summary') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Books Reading Card -->
                        <div class="card p-6 bg-white border border-secondary-blush hover:shadow-md transition duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">{{ __('Books I\'m Reading') }}</h4>
                                <div class="p-3 bg-secondary-blush/60 rounded-2xl text-primary-rose">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            </div>
                            <p class="text-4xl font-display font-bold text-primary-rose">{{ $activeBorrowingsCount }}</p>
                        </div>

                        <!-- Total Borrowed Books Card -->
                        <div class="card p-6 bg-white border border-secondary-blush hover:shadow-md transition duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total Borrowed Books') }}</h4>
                                <div class="p-3 bg-secondary-blush/60 rounded-2xl text-primary-rose">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                            </div>
                            <p class="text-4xl font-display font-bold text-primary-rose">{{ $totalBorrowingsCount }}</p>
                        </div>
                    </div>

                    <!-- Nearest Return Deadline Box with custom animations -->
                    <div class="card p-6 bg-white border border-secondary-blush hover:shadow-md transition duration-300 relative overflow-hidden">
                        <div class="flex items-center gap-4">
                            <!-- Pulsing notification ring -->
                            <div class="relative flex items-center justify-center">
                                @if($nearestDeadlineBorrowing)
                                    <span class="absolute inline-flex h-12 w-12 rounded-full bg-rose-400 opacity-20 animate-ping"></span>
                                    <div class="relative p-3 bg-rose-50 border border-rose-100 rounded-full text-rose-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                @else
                                    <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-full text-emerald-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h4 class="text-lg font-display font-bold text-text-charcoal mb-1">{{ __('Nearest Return Deadline') }}</h4>
                                @if($nearestDeadlineBorrowing)
                                    <p class="text-sm text-gray-500 font-semibold">
                                        {{ __('You need to return') }} <span class="text-primary-rose font-bold">"{{ $nearestDeadlineBorrowing->book->title }}"</span> {{ __('before') }}
                                        <span class="text-rose-500 font-bold underline">{{ date('d M Y', strtotime($nearestDeadlineBorrowing->return_date)) }}</span>.
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 font-medium">
                                        {{ __('No active deadlines! Keep reading comfortably.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Borrowing Overview Timeline / Quick List (Right Column) -->
                <div class="card p-6 bg-white border border-secondary-blush flex flex-col h-full self-start">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-display font-bold text-text-charcoal">{{ __('Active Borrowings') }}</h3>
                        <a href="{{ route('peminjam.history') }}" class="text-xs font-bold text-primary-rose hover:underline">{{ __('View All') }}</a>
                    </div>
                    
                    <div class="flex-1 space-y-4 overflow-y-auto max-h-[300px]">
                        @php
                            $activeList = auth()->user()->borrowings()->where('status', 'borrowed')->with('book')->take(3)->get();
                        @endphp
                        @forelse($activeList as $borrowing)
                            <div class="p-3 bg-secondary-blush/30 rounded-2xl border border-secondary-blush/10 hover:bg-secondary-blush/50 transition">
                                <div class="font-bold text-sm text-text-charcoal leading-tight mb-1 truncate" title="{{ $borrowing->book->title }}">
                                    {{ $borrowing->book->title }}
                                </div>
                                <div class="text-[10px] text-gray-400 font-semibold flex items-center justify-between">
                                    <span>{{ __('Pinjam') }}: {{ date('d/m/Y', strtotime($borrowing->borrow_date)) }}</span>
                                    <span class="text-rose-500 font-bold uppercase">{{ __('Tenggat') }}: {{ date('d/m/Y', strtotime($borrowing->return_date)) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-400 font-medium text-sm">
                                {{ __('No active borrowings at the moment.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recommendations Section with Hover Scale animation -->
            <div class="space-y-6">
                <h3 class="text-2xl font-display font-bold text-text-charcoal">{{ __('Book Recommendations of the Week') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($recommendations as $book)
                        <div class="card p-4 bg-white border border-secondary-blush/40 hover:shadow-md transition duration-300 transform hover:scale-105">
                            <!-- Image Frame -->
                            <div class="relative w-full aspect-[3/4] mb-4 bg-secondary-blush/20 rounded-2xl overflow-hidden border border-secondary-blush/20">
                                @if(filter_var($book->cover_image, FILTER_VALIDATE_URL))
                                    <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @elseif($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-primary-rose">
                                        <span class="text-xs font-bold font-display uppercase">No Cover</span>
                                    </div>
                                @endif
                                <span class="absolute top-2 left-2 px-2.5 py-0.5 bg-white/95 backdrop-blur-sm text-primary-rose text-[9px] font-bold uppercase rounded-lg border border-secondary-blush/60 shadow-xs">
                                    {{ $book->category->name }}
                                </span>
                            </div>
                            <!-- Meta -->
                            <h4 class="font-display font-bold text-sm text-text-charcoal leading-tight truncate mb-1" title="{{ $book->title }}">{{ $book->title }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold mb-2">{{ $book->writer }}</p>
                            
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-secondary-blush/20">
                                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wide flex items-center gap-1">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                    {{ __('Ready') }}
                                </span>
                                <a href="{{ route('peminjam.catalog', ['search' => $book->title]) }}" class="text-[10px] font-bold text-primary-rose hover:underline">
                                    {{ __('Search') }} &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    @else
        <!-- ================= STAFF / ADMIN VIEW ================= -->
        <div x-data="{ openBorrowingModal: false, openBookModal: false }" class="animate-fadeIn space-y-8">
            
            <!-- Welcoming Animated Hero Section with Fade-In-Up motion -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-primary-rose to-secondary-blush p-8 md:p-12 shadow-md text-text-charcoal border border-white/20 animate-slideUp">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/20 rounded-full blur-3xl filter opacity-80 animate-pulse"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-display font-bold mb-4 tracking-wide text-text-charcoal">
                        {{ __('Welcome back to the Command Center, :name!', ['name' => auth()->user()->name]) }}
                    </h2>
                    <p class="text-sm md:text-base font-semibold text-text-charcoal/80 mb-6 leading-relaxed max-w-2xl">
                        {{ __('Hello, :name! Today we have :overdue books overdue or due for return, and :outOfStock titles currently out of stock. Let\'s ensure smooth circulation today!', ['name' => auth()->user()->name, 'overdue' => $pendingOverdueCount, 'outOfStock' => $outOfStockBooksCount]) }}
                    </p>
                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl text-xs font-bold text-text-charcoal shadow-sm">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                        </span>
                        <span>{{ __(':count Operations Pending Attention Today', ['count' => $pendingTasksCount]) }}</span>
                    </div>
                </div>
            </div>

            <!-- Asymmetrical Grid with stats and quick action widget -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left/Center Column (Col-Span 2): Stats & Visual Meters -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Stats Cards Subgrid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Total Books Card -->
                        <div class="card p-6 bg-gradient-to-br from-white to-secondary-blush/40 border border-secondary-blush/50 shadow-sm hover:scale-105 hover:shadow-[0_8px_30px_rgba(243,197,197,0.25)] transition duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Total Books') }}</h3>
                                <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose group-hover:scale-110 transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            </div>
                            <p class="text-4xl font-display font-bold text-primary-rose">{{ $staffTotalBooks }}</p>
                        </div>

                        <!-- Active Borrowings Card -->
                        <div class="card p-6 bg-gradient-to-br from-white to-pink-50/50 border border-secondary-blush/50 shadow-sm hover:scale-105 hover:shadow-[0_8px_30px_rgba(243,197,197,0.25)] transition duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Active Borrowings') }}</h3>
                                <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose group-hover:scale-110 transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <p class="text-4xl font-display font-bold text-primary-rose">{{ $staffActiveBorrowings }}</p>
                        </div>

                        <!-- Overdue Books Card -->
                        <div class="card p-6 bg-gradient-to-br from-white to-rose-50/50 border border-secondary-blush/50 shadow-sm hover:scale-105 hover:shadow-[0_8px_30px_rgba(239,68,68,0.15)] transition duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Overdue Books') }}</h3>
                                <div class="p-3 bg-white rounded-2xl shadow-sm text-red-400 group-hover:scale-110 transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                            </div>
                            <p class="text-4xl font-display font-bold text-red-500">{{ $staffOverdueBorrowings }}</p>
                        </div>
                    </div>

                    <!-- Interactive Analytics Panel (Circular Gauge and Popular Category Grid) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Fulfillment Rate Circular Meter -->
                        <div class="card p-6 bg-white border border-secondary-blush flex flex-col justify-between items-center text-center">
                            <h4 class="text-sm font-display font-bold text-text-charcoal mb-4 uppercase tracking-wider">{{ __('Circulation Fulfillment Rate') }}</h4>
                            <div class="relative w-36 h-36 flex items-center justify-center">
                                <!-- Outer Background Circle -->
                                <svg class="w-full h-full transform -rotate-90">
                                    <circle cx="72" cy="72" r="60" stroke="#FCEAEA" stroke-width="12" fill="transparent" />
                                    <circle cx="72" cy="72" r="60" stroke="#F3C5C5" stroke-width="12" fill="transparent"
                                            stroke-dasharray="377"
                                            stroke-dashoffset="{{ 377 - (377 * $fulfillmentRate) / 100 }}"
                                            stroke-linecap="round"
                                            class="transition-all duration-1000 ease-out" />
                                </svg>
                                <div class="absolute flex flex-col items-center">
                                    <span class="text-3xl font-display font-bold text-primary-rose">{{ $fulfillmentRate }}%</span>
                                    <span class="text-[9px] text-gray-400 font-semibold uppercase tracking-wider">{{ __('Return Ratio') }}</span>
                                </div>
                            </div>
                            <p class="text-xs font-semibold text-gray-500 mt-4 leading-relaxed max-w-[200px]">
                                {{ __('Successful Returns vs Total Borrowings') }}
                            </p>
                        </div>

                        <!-- Category Popularity Progress Bars -->
                        <div class="card p-6 bg-white border border-secondary-blush flex flex-col justify-between">
                            <h4 class="text-sm font-display font-bold text-text-charcoal mb-4 uppercase tracking-wider">{{ __('Popular Categories') }}</h4>
                            <div class="space-y-4">
                                @forelse($categoryPopularity as $cat)
                                    <div class="space-y-1">
                                        <div class="flex justify-between items-center text-xs font-bold">
                                            <span class="px-2.5 py-0.5 bg-secondary-blush text-primary-rose rounded-lg border border-primary-rose/30 shadow-xs text-[10px]">{{ $cat->name }}</span>
                                            <span class="text-text-charcoal/70 text-[10px]">{{ $cat->borrow_count }} {{ __('Logs') }}</span>
                                        </div>
                                        <div class="w-full bg-secondary-blush/40 h-2 rounded-full overflow-hidden border border-secondary-blush/20">
                                            <div class="bg-primary-rose h-full rounded-full transition-all duration-1000" style="width: {{ $cat->percentage }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-400 text-xs font-bold">
                                        {{ __('No category data to display.') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Col-Span 1): Administrative "Quick Action Center" -->
                <div class="lg:col-span-1">
                    <div class="card p-6 bg-white border border-secondary-blush/60 flex flex-col h-full self-start">
                        <h3 class="text-lg font-display font-bold text-text-charcoal mb-5 uppercase tracking-wider border-b border-secondary-blush/30 pb-3">{{ __('Quick Actions') }}</h3>
                        <div class="space-y-4">
                            <!-- Record New Borrowing -->
                            <button @click="openBorrowingModal = true" class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-white to-secondary-blush/20 hover:to-secondary-blush/50 border border-secondary-blush/40 hover:border-primary-rose/40 rounded-2xl text-left transition duration-200 transform hover:-translate-y-1 group shadow-xs">
                                <div class="flex items-center gap-3">
                                    <div class="p-3 bg-white rounded-xl text-primary-rose shadow-xs group-hover:scale-110 transition duration-200 border border-secondary-blush">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-display font-bold text-text-charcoal">{{ __('Record Borrowing') }}</h4>
                                        <p class="text-[10px] text-gray-400 font-semibold mt-0.5">{{ __('Record new book checkout') }}</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary-rose transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <!-- Add New Book -->
                            <button @click="openBookModal = true" class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-white to-secondary-blush/20 hover:to-secondary-blush/50 border border-secondary-blush/40 hover:border-primary-rose/40 rounded-2xl text-left transition duration-200 transform hover:-translate-y-1 group shadow-xs">
                                <div class="flex items-center gap-3">
                                    <div class="p-3 bg-white rounded-xl text-primary-rose shadow-xs group-hover:scale-110 transition duration-200 border border-secondary-blush">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-display font-bold text-text-charcoal">{{ __('Add Book') }}</h4>
                                        <p class="text-[10px] text-gray-400 font-semibold mt-0.5">{{ __('Add new title to catalog') }}</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary-rose transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <!-- View Circulation Reports -->
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.reports') }}" class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-white to-secondary-blush/20 hover:to-secondary-blush/50 border border-secondary-blush/40 hover:border-primary-rose/40 rounded-2xl text-left transition duration-200 transform hover:-translate-y-1 group shadow-xs">
                                    <div class="flex items-center gap-3">
                                        <div class="p-3 bg-white rounded-xl text-primary-rose shadow-xs group-hover:scale-110 transition duration-200 border border-secondary-blush">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m32-12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-display font-bold text-text-charcoal">{{ __('View Circulation Reports') }}</h4>
                                            <p class="text-[10px] text-gray-400 font-semibold mt-0.5">{{ __('View analytics & reports') }}</p>
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-300 group-hover:text-primary-rose transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @else
                                <div class="relative cursor-not-allowed group">
                                    <div class="w-full flex items-center justify-between p-4 bg-gray-50 border border-gray-100 rounded-2xl text-left opacity-60">
                                        <div class="flex items-center gap-3">
                                            <div class="p-3 bg-white rounded-xl text-gray-400 border border-gray-100 shadow-xs">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m32-12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-display font-bold text-gray-400">{{ __('View Circulation Reports') }}</h4>
                                                <p class="text-[10px] text-gray-400 font-semibold mt-0.5">{{ __('Restricted to Administrators') }}</p>
                                            </div>
                                        </div>
                                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0-8V7m0 0v2m0-2h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"></path></svg>
                                    </div>
                                    <!-- Hover Tooltip explaining restriction -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-56 p-2 bg-text-charcoal text-white text-[10px] rounded-xl opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none text-center shadow-md leading-relaxed z-20">
                                        {{ __('This feature is restricted to Admin role.') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Dynamic Activity Timeline for Recent Activity -->
            <div class="card p-6 bg-white border border-secondary-blush/60 shadow-xs">
                <h3 class="text-xl font-display font-bold text-text-charcoal mb-6">{{ __('Recent Activity') }}</h3>
                
                <div class="relative pl-6 border-l-2 border-secondary-blush/60 space-y-6">
                    @forelse($recentActivity as $index => $item)
                        <div class="relative flex items-start gap-4 animate-fadeIn" style="animation-delay: {{ $index * 100 }}ms">
                            <!-- Timeline point marker -->
                            <div class="absolute -left-[31px] mt-1.5 w-4 h-4 rounded-full bg-white border-4 border-primary-rose shadow-xs"></div>
                            
                            <!-- Avatar Placeholder -->
                            <div class="flex-shrink-0 w-10 h-10 bg-secondary-blush text-primary-rose font-display font-bold text-sm rounded-full flex items-center justify-center border border-primary-rose/20 shadow-xs">
                                {{ strtoupper(substr($item->user->name, 0, 2)) }}
                            </div>
                            
                            <!-- Content Body -->
                            <div class="flex-1 min-w-0 bg-bg-cream/40 p-4 rounded-2xl border border-secondary-blush/30 hover:bg-secondary-blush/10 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                    <p class="text-sm font-bold text-text-charcoal">
                                        {{ $item->user->name }}
                                    </p>
                                    <div class="flex items-center gap-2">
                                        @if($item->status === 'borrowed')
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                            </span>
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-100 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                                {{ __('Borrowed') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                {{ __('Returned') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 font-semibold leading-relaxed">
                                    {{ __('Borrowed book') }} <span class="text-primary-rose font-bold">"{{ $item->book->title }}"</span> {{ __('by') }} {{ $item->book->writer }}.
                                </p>
                                <div class="flex items-center justify-between mt-3 pt-2 border-t border-secondary-blush/20 text-[10px] text-gray-400 font-bold">
                                    <span>{{ __('Pinjam') }}: {{ date('d M Y', strtotime($item->borrow_date)) }}</span>
                                    <span class="text-rose-500 font-extrabold uppercase">{{ __('Tenggat') }}: {{ date('d M Y', strtotime($item->return_date)) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty state fallback with premium custom SVG book placeholder -->
                        <div class="py-12 flex flex-col items-center justify-center text-center space-y-4">
                            <svg class="w-20 h-20 text-primary-rose/40 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-text-charcoal">{{ __('No library transactions today.') }}</p>
                                <p class="text-xs text-gray-400 font-semibold">{{ __('All circulation systems are empty and waiting for records.') }}</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ================= ACTION MODALS ================= -->
            <!-- Borrowing Record Modal -->
            <div x-show="openBorrowingModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-text-charcoal/40 backdrop-blur-xs animate-fadeIn" x-cloak>
                <div @click.away="openBorrowingModal = false" class="card w-full max-w-lg p-8 bg-white border border-primary-rose/40 shadow-2xl relative"
                     x-show="openBorrowingModal"
                     x-transition:enter="transition-premium transform"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition-premium transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                    
                    <button @click="openBorrowingModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-text-charcoal transition p-1 hover:bg-secondary-blush rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <h3 class="text-2xl font-display font-bold text-text-charcoal mb-6 border-b border-secondary-blush/30 pb-3">{{ __('Record Borrowing') }}</h3>

                    <form method="POST" action="{{ route('borrowings.store') }}" x-data="{ submitted: false }" @submit="submitted = true">
                        @csrf
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Borrower') }}</label>
                                <select name="user_id" class="input-field py-3 px-4" required>
                                    <option value="">{{ __('Select Borrower') }}</option>
                                    @foreach($borrowersList as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Select Book') }}</label>
                                <select name="book_id" class="input-field py-3 px-4" required>
                                    <option value="">{{ __('Select Book') }}</option>
                                    @foreach($booksList as $bk)
                                        <option value="{{ $bk->id }}">{{ $bk->title }} ({{ __('Stok') }}: {{ $bk->stock }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Borrow Date') }}</label>
                                    <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" class="input-field py-3 px-4 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Return Date') }}</label>
                                    <input type="date" name="return_date" class="input-field py-3 px-4 text-sm" placeholder="{{ __('Defaults to 7 days') }}">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 border-t border-secondary-blush/30 pt-4">
                            <button type="button" @click="openBorrowingModal = false" class="px-6 py-3 bg-secondary-blush border border-primary-rose rounded-2xl font-display font-semibold text-primary-rose uppercase tracking-widest hover:bg-rose-50 text-[10px] transition duration-150">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" :disabled="submitted" class="btn-primary py-3 px-6 text-[10px] inline-flex items-center gap-2">
                                <template x-if="submitted">
                                    <svg class="animate-spin h-3.5 w-3.5 text-text-charcoal" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <span x-text="submitted ? '{{ __('Processing...') }}' : '{{ __('Save') }}'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Book Registration Modal -->
            <div x-show="openBookModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-text-charcoal/40 backdrop-blur-xs animate-fadeIn" x-cloak>
                <div @click.away="openBookModal = false" class="card w-full max-w-lg p-8 bg-white border border-primary-rose/40 shadow-2xl relative max-h-[90vh] overflow-y-auto"
                     x-show="openBookModal"
                     x-transition:enter="transition-premium transform"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition-premium transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                    
                    <button @click="openBookModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-text-charcoal transition p-1 hover:bg-secondary-blush rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <h3 class="text-2xl font-display font-bold text-text-charcoal mb-6 border-b border-secondary-blush/30 pb-3">{{ __('Add Book') }}</h3>

                    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" x-data="{ submitted: false }" @submit="submitted = true">
                        @csrf
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Book Title') }}</label>
                                <input type="text" name="title" class="input-field py-2.5 px-4 text-sm" placeholder="{{ __('e.g. Harry Potter') }}" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Writer') }}</label>
                                    <input type="text" name="writer" class="input-field py-2.5 px-4 text-sm" placeholder="{{ __('e.g. J.K. Rowling') }}" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Publisher') }}</label>
                                    <input type="text" name="publisher" class="input-field py-2.5 px-4 text-sm" placeholder="{{ __('e.g. Gramedia') }}" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Year') }}</label>
                                    <input type="number" name="year" value="{{ date('Y') }}" class="input-field py-2.5 px-4 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('ISBN') }}</label>
                                    <input type="text" name="ISBN" class="input-field py-2.5 px-4 text-sm" placeholder="13-digit" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Stock') }}</label>
                                    <input type="number" name="stock" min="0" class="input-field py-2.5 px-4 text-sm" placeholder="e.g. 5" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Category') }}</label>
                                <select name="category_id" class="input-field py-3 px-4 text-sm" required>
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach($allCategoriesList as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Cover Image') }}</label>
                                <input type="file" name="cover_image" class="input-field py-2 px-3 text-xs" accept="image/*">
                                <p class="text-[9px] text-gray-400 mt-1 font-semibold">{{ __('Maximum image upload size: 2MB') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 border-t border-secondary-blush/30 pt-4">
                            <button type="button" @click="openBookModal = false" class="px-6 py-3 bg-secondary-blush border border-primary-rose rounded-2xl font-display font-semibold text-primary-rose uppercase tracking-widest hover:bg-rose-50 text-[10px] transition duration-150">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" :disabled="submitted" class="btn-primary py-3 px-6 text-[10px] inline-flex items-center gap-2">
                                <template x-if="submitted">
                                    <svg class="animate-spin h-3.5 w-3.5 text-text-charcoal" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <span x-text="submitted ? '{{ __('Processing...') }}' : '{{ __('Save') }}'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    @endif

    <style>
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
        .animate-slideUp {
            animation: slideUp 0.6s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
@endsection

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
        <div class="mb-8">
            <h2 class="text-3xl font-display font-bold text-text-charcoal mb-2">{{ __('Welcome back to BookSpace') }}!</h2>
            <p class="text-gray-500 font-medium">{{ __('Here is an overview of your library activity today.') }}</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card p-6 bg-gradient-to-br from-white to-secondary-blush border-none shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Total Books') }}</h3>
                    <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <p class="text-4xl font-display font-bold text-primary-rose">{{ $staffTotalBooks }}</p>
            </div>

            <div class="card p-6 bg-gradient-to-br from-white to-pink-50 border-none shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Active Borrowings') }}</h3>
                    <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-4xl font-display font-bold text-primary-rose">{{ $staffActiveBorrowings }}</p>
            </div>

            <div class="card p-6 bg-gradient-to-br from-white to-rose-50 border-none shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Overdue Books') }}</h3>
                    <div class="p-3 bg-white rounded-2xl shadow-sm text-red-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
                <p class="text-4xl font-display font-bold text-red-500">{{ $staffOverdueBorrowings }}</p>
            </div>
        </div>

        <!-- Recent Activity Ledger (Placeholder) -->
        <div class="card p-6 bg-white border border-secondary-blush/60 shadow-xs">
            <h3 class="text-xl font-display font-bold text-text-charcoal mb-4">{{ __('Recent Activity') }}</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-xs uppercase">
                            <th class="py-3 px-4 font-display">#</th>
                            <th class="py-3 px-4 font-display">{{ __('Borrower') }}</th>
                            <th class="py-3 px-4 font-display">{{ __('Book Title') }}</th>
                            <th class="py-3 px-4 font-display">{{ __('Borrow Date') }}</th>
                            <th class="py-3 px-4 font-display">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-blush/30 font-medium text-sm">
                        @php
                            $recentList = \App\Models\Borrowing::with(['user', 'book'])->latest()->take(5)->get();
                        @endphp
                        @forelse($recentList as $index => $item)
                            <tr class="hover:bg-secondary-blush/10 transition">
                                <td class="py-3 px-4 text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 text-text-charcoal font-bold">{{ $item->user->name }}</td>
                                <td class="py-3 px-4 text-gray-700 font-semibold">{{ $item->book->title }}</td>
                                <td class="py-3 px-4 text-gray-500">{{ date('d M Y', strtotime($item->borrow_date)) }}</td>
                                <td class="py-3 px-4">
                                    @if($item->status === 'borrowed')
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-100 rounded text-xs font-bold uppercase tracking-wider">{{ __('Borrowed') }}</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded text-xs font-bold uppercase tracking-wider">{{ __('Returned') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-400">
                                    {{ __('No recent activity to display.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

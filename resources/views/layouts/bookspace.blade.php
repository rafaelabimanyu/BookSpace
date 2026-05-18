<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BookSpace') }} - @yield('title', __('Dashboard'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-cream text-text-charcoal font-sans antialiased min-h-screen flex">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-secondary-blush border-r border-white/50 shadow-sm flex flex-col min-h-screen">
        <div class="h-20 flex items-center justify-center border-b border-white/50">
            <a href="/" class="flex items-center gap-2">
                <svg class="w-7 h-7 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h1 class="text-2xl font-display font-bold text-primary-rose tracking-wide">BookSpace</h1>
            </a>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition {{ Request::routeIs('dashboard') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('Dashboard') }}
            </a>
            
            @if(in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition {{ Request::routeIs('categories.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    {{ __('Categories') }}
                </a>

                <a href="{{ route('books.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition {{ Request::routeIs('books.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ __('Books') }}
                </a>

                <a href="{{ route('borrowings.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition {{ Request::routeIs('borrowings.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('Borrowings') }}
                </a>
            @endif

            @if(auth()->user()->role === 'peminjam')
                <a href="{{ route('peminjam.catalog') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition {{ Request::routeIs('peminjam.catalog') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ __('Book Catalog') }}
                </a>

                <a href="{{ route('peminjam.history') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition {{ Request::routeIs('peminjam.history') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('My Borrowing History') }}
                </a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition {{ Request::routeIs('admin.reports') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                    {{ __('Reports') }}
                </a>
            @endif
        </nav>

        <div class="p-4 border-t border-white/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-white text-text-charcoal hover:bg-rose-50 hover:text-primary-rose rounded-2xl font-bold transition shadow-sm border border-secondary-blush">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- Top Header -->
        <header class="h-20 bg-white/50 backdrop-blur-md border-b border-secondary-blush flex items-center justify-between px-8 z-10 sticky top-0">
            <div class="flex items-center gap-4">
                <span class="text-lg font-display font-semibold text-text-charcoal">@yield('header_title')</span>
                <span class="px-3 py-1 bg-secondary-blush text-primary-rose text-xs font-bold uppercase tracking-wider rounded-xl">{{ __(ucfirst(auth()->user()->role)) }}</span>
            </div>

            <div class="flex items-center gap-6">
                <!-- Language Switcher -->
                <div class="flex items-center bg-white rounded-2xl shadow-sm border border-secondary-blush p-1">
                    <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1 rounded-xl text-sm font-semibold transition {{ app()->getLocale() === 'en' ? 'bg-primary-rose text-white' : 'text-text-charcoal hover:bg-secondary-blush' }}">
                        EN
                    </a>
                    <a href="{{ route('locale.switch', 'id') }}" class="px-3 py-1 rounded-xl text-sm font-semibold transition {{ app()->getLocale() === 'id' ? 'bg-primary-rose text-white' : 'text-text-charcoal hover:bg-secondary-blush' }}">
                        ID
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Inner Content -->
        <div class="p-8 flex-1">
            <!-- Toast Notifications -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-2 shadow-sm font-medium">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-2 shadow-sm font-medium">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BookSpace') }} - {{ __('Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-cream text-text-charcoal font-sans antialiased min-h-screen flex">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-secondary-blush border-r border-white/50 shadow-sm flex flex-col">
        <div class="h-20 flex items-center justify-center border-b border-white/50">
            <h1 class="text-2xl font-display font-bold text-primary-rose">BookSpace</h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 bg-white rounded-2xl shadow-sm text-primary-rose font-bold transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('Dashboard') }}
            </a>
            
            @if(auth()->user()->role === 'admin')
                <a href="#" class="flex items-center px-4 py-3 text-text-charcoal hover:bg-white/50 hover:text-primary-rose rounded-2xl font-semibold transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('User Management') }}
                </a>
            @endif

            @if(in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="#" class="flex items-center px-4 py-3 text-text-charcoal hover:bg-white/50 hover:text-primary-rose rounded-2xl font-semibold transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ __('Book Catalog') }}
                </a>
            @endif
        </nav>

        <div class="p-4 border-t border-white/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-white text-text-charcoal hover:bg-rose-50 hover:text-primary-rose rounded-2xl font-bold transition shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- Top Navbar -->
        <header class="h-20 bg-white/50 backdrop-blur-md border-b border-secondary-blush flex items-center justify-between px-8 z-10 sticky top-0">
            <div class="flex items-center gap-4">
                <span class="text-lg font-display font-semibold text-text-charcoal">{{ __('Hello') }}, {{ auth()->user()->name }}</span>
                <span class="px-3 py-1 bg-secondary-blush text-primary-rose text-xs font-bold uppercase tracking-wider rounded-xl">{{ __(ucfirst(auth()->user()->role)) }}</span>
            </div>

            <!-- Language Switcher -->
            <div class="flex items-center bg-white rounded-2xl shadow-sm border border-secondary-blush p-1">
                <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1 rounded-xl text-sm font-semibold transition {{ app()->getLocale() === 'en' ? 'bg-primary-rose text-white' : 'text-text-charcoal hover:bg-secondary-blush' }}">
                    EN
                </a>
                <a href="{{ route('locale.switch', 'id') }}" class="px-3 py-1 rounded-xl text-sm font-semibold transition {{ app()->getLocale() === 'id' ? 'bg-primary-rose text-white' : 'text-text-charcoal hover:bg-secondary-blush' }}">
                    ID
                </a>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="p-8">
            <div class="mb-8">
                <h2 class="text-3xl font-display font-bold text-text-charcoal mb-2">{{ __('Welcome back to BookSpace') }}!</h2>
                <p class="text-gray-500 font-medium">{{ __('Here is an overview of your library activity today.') }}</p>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card p-6 bg-gradient-to-br from-white to-secondary-blush border-none">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Total Books') }}</h3>
                        <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-display font-bold text-primary-rose">245</p>
                </div>

                <div class="card p-6 bg-gradient-to-br from-white to-pink-50 border-none">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Active Borrowings') }}</h3>
                        <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-display font-bold text-primary-rose">12</p>
                </div>

                <div class="card p-6 bg-gradient-to-br from-white to-rose-50 border-none">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Overdue Books') }}</h3>
                        <div class="p-3 bg-white rounded-2xl shadow-sm text-red-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-display font-bold text-red-500">2</p>
                </div>
            </div>

            <!-- Recent Activity Placeholder -->
            <div class="card p-6">
                <h3 class="text-xl font-display font-bold text-text-charcoal mb-4">{{ __('Recent Activity') }}</h3>
                <div class="text-center py-10 text-gray-400 font-medium">
                    {{ __('No recent activity to display.') }}
                </div>
            </div>
        </div>
    </main>
</body>
</html>

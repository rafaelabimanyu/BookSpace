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
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('dashboard') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('Dashboard') }}
            </a>
            
            @if(in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('categories.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    {{ __('Categories') }}
                </a>

                <a href="{{ route('books.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('books.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ __('Books') }}
                </a>

                <a href="{{ route('borrowings.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('borrowings.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('Borrowings') }}
                </a>

                <a href="{{ route('fines.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('fines.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('Fines Management') }}
                </a>
            @endif

            @if(auth()->user()->role === 'peminjam')
                <a href="{{ route('peminjam.catalog') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('peminjam.catalog') || Request::routeIs('peminjam.books.show') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ __('Book Catalog') }}
                </a>

                <a href="{{ route('peminjam.wishlist') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('peminjam.wishlist') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    {{ __('My Wishlist') }}
                </a>

                <a href="{{ route('peminjam.fines') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('peminjam.fines') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:bg-white/50 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('Fines & Penalties') }}
                </a>

                <a href="{{ route('peminjam.history') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('peminjam.history') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('My Borrowing History') }}
                </a>

                <a href="{{ route('peminjam.profile') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('peminjam.profile') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('My Profile') }}
                </a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('admin.users.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('User Management') }}
                </a>

                <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('admin.reports') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                    {{ __('Reports') }}
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 rounded-2xl font-bold transition-premium active:scale-95 duration-100 {{ Request::routeIs('admin.settings.*') ? 'bg-white shadow-sm text-primary-rose' : 'text-text-charcoal hover:translate-x-1 hover:bg-white/70 hover:text-primary-rose' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ __('System Settings') }}
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
        <header class="h-20 bg-white/60 backdrop-blur-md border-b border-secondary-blush/40 flex items-center justify-between px-8 z-10 sticky top-0 shadow-xs">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-display font-bold text-text-charcoal">@yield('header_title', __('Dashboard'))</h2>
            </div>

            <div class="flex items-center gap-6">
                <!-- User Greeting & Role Badge -->
                <span class="font-body font-bold text-text-charcoal text-sm">{{ __('Hello, :name', ['name' => auth()->user()->name]) }}</span>
                <span class="rounded-full px-3 py-1 text-[10px] font-extrabold text-primary-rose bg-secondary-blush border border-primary-rose/30 uppercase tracking-widest shadow-xs">
                    {{ __(ucfirst(auth()->user()->role)) }}
                </span>

                <!-- Language Switcher -->
                <div class="flex items-center bg-white/95 rounded-full shadow-xs border border-secondary-blush/60 p-1">
                    <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1 rounded-full text-xs font-bold transition-all duration-200 transform hover:scale-105 active:scale-95 {{ app()->getLocale() === 'en' ? 'bg-primary-rose text-white shadow-xs font-bold' : 'text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose' }}">
                        EN
                    </a>
                    <a href="{{ route('locale.switch', 'id') }}" class="px-3 py-1 rounded-full text-xs font-bold transition-all duration-200 transform hover:scale-105 active:scale-95 {{ app()->getLocale() === 'id' ? 'bg-primary-rose text-white shadow-xs font-bold' : 'text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose' }}">
                        ID
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-8">
            <div class="animate-fade-in-up">
                @yield('content')
            </div>
        </main>

        <!-- Global Footer -->
        <footer class="bg-white/60 backdrop-blur-md border-t border-secondary-blush py-6 px-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-semibold text-text-charcoal/70">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span class="font-display font-bold text-text-charcoal tracking-wide">BookSpace</span>
            </div>
            <div class="text-center text-text-charcoal/60">
                &copy; {{ date('Y') }} BookSpace. {{ __('All rights reserved.') }}
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 text-text-charcoal/60">
                    <a href="#" class="transition-all duration-300 hover:text-primary-rose">{{ __('About') }}</a>
                    <span>&middot;</span>
                    <a href="#" class="transition-all duration-300 hover:text-primary-rose">{{ __('Contact') }}</a>
                </div>
                <div class="flex items-center gap-1 text-text-charcoal/50 text-[11px]">
                    <span>{{ __('Made with') }}</span>
                    <svg class="w-3.5 h-3.5 text-primary-rose fill-current animate-pulse" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span>{{ __('in BookSpace') }}</span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Global Animated Soft-Pink Toasts -->
    <div
        x-data="{
            toasts: [],
            addToast(message, type = 'success') {
                const id = Date.now();
                this.toasts.push({ id, message, type });
                setTimeout(() => this.removeToast(id), 5000);
            },
            removeToast(id) {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }
        }"
        x-init="
            @if(session('success')) addToast('{{ addslashes(session('success')) }}', 'success'); @endif
            @if(session('error')) addToast('{{ addslashes(session('error')) }}', 'error'); @endif
        "
        @trigger-toast.window="addToast($event.detail.message, $event.detail.type)"
        class="fixed top-6 right-6 z-50 flex flex-col gap-3 w-full max-w-sm"
    >
        <template x-for="toast in toasts" :key="toast.id">
            <div
                x-show="true"
                x-transition:enter="transition-premium"
                x-transition:enter-start="translate-x-12 opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition-premium"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-12 opacity-0"
                class="w-full bg-secondary-blush border border-primary-rose text-text-charcoal p-4 rounded-2xl shadow-lg flex items-start gap-3 backdrop-blur-md bg-opacity-95"
            >
                <!-- Icon -->
                <div class="flex-shrink-0 mt-0.5">
                    <template x-if="toast.type === 'success'">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white text-primary-rose border border-primary-rose/30 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white text-rose-500 border border-rose-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                    </template>
                </div>
                <!-- Content -->
                <div class="flex-1">
                    <p class="text-sm font-bold text-text-charcoal" x-text="toast.message"></p>
                </div>
                <!-- Close -->
                <button @click="removeToast(toast.id)" class="flex-shrink-0 text-text-charcoal/40 hover:text-text-charcoal transition p-0.5 rounded-lg hover:bg-white/40">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </template>
    </div>

</body>
</html>

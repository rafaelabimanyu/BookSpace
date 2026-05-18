<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <title>BookSpace</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }
        .animate-blob {
            animation: blob 8s infinite ease-in-out alternate;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
            100% { transform: translate(-10px, 10px) scale(0.95); }
        }
    </style>
</head>
<body class="bg-bg-cream text-text-charcoal antialiased min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Premium Soft-Pink Glowing Ambient Background Elements -->
    <div class="absolute top-10 left-10 w-96 h-96 bg-secondary-blush/60 rounded-full filter blur-[80px] animate-blob"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-rose-200/40 rounded-full filter blur-[80px] animate-blob animation-delay-2000"></div>

    <!-- Header (Navbar) -->
    <header class="w-full py-6 px-8 flex justify-between items-center relative z-10">
        <!-- LEFT SIDE: Blank (Empty as requested to emphasize central focus) -->
        <div></div>

        <!-- RIGHT SIDE: Language Switcher & Authentication links -->
        <div class="flex items-center gap-6">
            <!-- Language Switcher (Soft-Pink Glassmorphism Pill) -->
            <div class="flex items-center bg-white/50 backdrop-blur-md rounded-2xl border border-secondary-blush p-1 shadow-sm">
                <a href="{{ route('locale.switch', 'en') }}" class="px-3.5 py-1 rounded-xl text-xs font-bold transition-all duration-300 {{ app()->getLocale() === 'en' ? 'bg-primary-rose text-white shadow-sm' : 'text-text-charcoal hover:text-primary-rose' }}">
                    EN
                </a>
                <a href="{{ route('locale.switch', 'id') }}" class="px-3.5 py-1 rounded-xl text-xs font-bold transition-all duration-300 {{ app()->getLocale() === 'id' ? 'bg-primary-rose text-white shadow-sm' : 'text-text-charcoal hover:text-primary-rose' }}">
                    ID
                </a>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-5">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-text-charcoal hover:text-primary-rose transition-premium">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-text-charcoal hover:text-primary-rose transition-premium">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2 bg-primary-rose border border-transparent rounded-2xl font-display font-semibold text-white uppercase tracking-widest text-[10px] hover:bg-rose-400 active:scale-95 transition-premium shadow-sm hover:shadow-md">{{ __('Register') }}</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex flex-col justify-center items-center px-6 py-10 relative z-10 text-center animate-fade-in-up">
        <!-- SECTION A: Central Logo Anchor & Introduction -->
        <div class="mb-8 flex flex-col items-center select-none">
            <!-- Luxury Soft-Pink Circular Logo Frame with Spinning Dashed border -->
            <div class="relative p-5 rounded-full bg-white/70 backdrop-blur-md border border-white/60 shadow-xl transition-all duration-700 hover:scale-105 hover:rotate-2 group">
                <div class="absolute inset-0 rounded-full border border-dashed border-primary-rose/30 animate-[spin_50s_linear_infinite] group-hover:border-solid"></div>
                <img src="{{ asset('assets/img/logo.png') }}" alt="BookSpace Logo" class="h-28 w-28 object-contain mx-auto relative z-10 filter drop-shadow-[0_4px_12px_rgba(224,90,109,0.18)]">
            </div>

            <!-- Teks Perkenalan Logo -->
            <div class="mt-6 text-center">
                <span class="font-display text-sm tracking-[0.25em] text-primary-rose font-bold uppercase block">BookSpace</span>
                <span class="text-[10px] font-sans font-bold tracking-[0.15em] text-text-charcoal/40 uppercase block mt-2">{{ __('Introducing the New Face of BookSpace') }}</span>
            </div>

            <!-- Soft Pink Premium Divider -->
            <div class="w-16 h-[1.5px] bg-gradient-to-r from-transparent via-primary-rose/40 to-transparent my-6"></div>
        </div>

        <!-- SECTION B: Streamlined Glassmorphism Card -->
        <div class="w-full max-w-xl bg-white/75 backdrop-blur-md border border-white/50 rounded-[2.5rem] p-10 md:p-12 shadow-2xl shadow-rose-100/30 transition-premium hover:shadow-rose-100/50">
            <!-- Font Display Bold Title -->
            <h1 class="font-display text-4xl md:text-5xl text-text-charcoal mb-5 leading-tight font-bold tracking-wide">
                {{ __('Welcome to BookSpace') }}
            </h1>
            
            <!-- Quicksand Semi-Bold Sleek Description -->
            <p class="text-sm md:text-base text-text-charcoal/70 leading-relaxed font-semibold mb-8 max-w-lg mx-auto">
                {{ __('Library Management System') }}. {{ __('Discover, organize, and immerse yourself in a world of endless reading possibilities with an elegant and soft touch.') }}
            </p>
            
            <!-- High-End Call to Actions (Tactile Active-scale transitions) -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary w-full sm:w-auto px-10 py-4 text-xs tracking-widest active:scale-95 transition-premium shadow-md shadow-primary-rose/20">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary w-full sm:w-auto px-10 py-4 text-xs tracking-widest active:scale-95 transition-premium shadow-md shadow-primary-rose/20">
                        {{ __('Register Now') }}
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary w-full sm:w-auto px-10 py-4 text-xs tracking-widest active:scale-95 transition-premium">
                        {{ __('Login') }}
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- Global Footer -->
    <footer class="bg-transparent py-8 px-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-semibold text-text-charcoal/60 border-t border-secondary-blush/30">
        <div class="flex items-center gap-2 select-none">
            <span class="font-display font-bold text-sm text-primary-rose tracking-wider">BookSpace</span>
        </div>
        <div class="text-text-charcoal/50">
            &copy; {{ date('Y') }} BookSpace. {{ __('All rights reserved.') }}
        </div>
        <div class="flex items-center gap-4 text-text-charcoal/50">
            <a href="#" class="transition-premium hover:text-primary-rose">{{ __('About') }}</a>
            <span>&middot;</span>
            <a href="#" class="transition-premium hover:text-primary-rose">{{ __('Contact') }}</a>
        </div>
    </footer>
</body>
</html>

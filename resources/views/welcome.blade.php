<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <title>BookSpace - Sanctuary of Books</title>

    <!-- Google Fonts: Cormorant Garamond (Luxurious Serif) & Plus Jakarta Sans (Clean Sans-Serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            background-color: #FAF9F5;
            color: #2C302E;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
        }
        .animate-subtle-glow {
            animation: subtleGlow 10s ease-in-out infinite alternate;
        }
        @keyframes subtleGlow {
            0% { transform: translate(0px, 0px) scale(1); opacity: 0.25; }
            50% { transform: translate(40px, -40px) scale(1.15); opacity: 0.4; }
            100% { transform: translate(-20px, 20px) scale(0.95); opacity: 0.25; }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Premium Glowing Background Elements -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#C5A880]/15 rounded-full filter blur-[100px] animate-subtle-glow"></div>
    <div class="absolute top-1/2 -right-40 w-96 h-96 bg-[#35524F]/10 rounded-full filter blur-[100px] animate-subtle-glow" style="animation-delay: 3s;"></div>

    <!-- Header (Navbar) -->
    <header class="w-full py-6 px-8 flex justify-between items-center relative z-10">
        <!-- LEFT SIDE: Blank (Empty as requested to emphasize central focus) -->
        <div></div>

        <!-- RIGHT SIDE: Navigation Controls -->
        <div class="flex items-center gap-6">
            <!-- Language Switcher (Premium Rounded Pill) -->
            <div class="flex items-center bg-white/40 backdrop-blur-md rounded-full border border-[#C5A880]/20 p-1 shadow-sm">
                <a href="{{ route('locale.switch', 'en') }}" class="px-3.5 py-1 rounded-full text-xs font-bold transition duration-300 {{ app()->getLocale() === 'en' ? 'bg-[#8C6239] text-[#FAF9F5] shadow-sm' : 'text-[#2C302E] hover:text-[#8C6239]' }}">
                    EN
                </a>
                <a href="{{ route('locale.switch', 'id') }}" class="px-3.5 py-1 rounded-full text-xs font-bold transition duration-300 {{ app()->getLocale() === 'id' ? 'bg-[#8C6239] text-[#FAF9F5] shadow-sm' : 'text-[#2C302E] hover:text-[#8C6239]' }}">
                    ID
                </a>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-[#2C302E] hover:text-[#8C6239] transition duration-300">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-[#2C302E] hover:text-[#8C6239] transition duration-300">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-[#8C6239] text-[#FAF9F5] hover:bg-[#6F4A25] px-5 py-2 rounded-full text-xs font-bold transition duration-300 shadow-sm shadow-[#8C6239]/10">{{ __('Register') }}</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex flex-col justify-center items-center px-6 py-12 relative z-10 text-center">
        <!-- SECTION A: Central Logo Anchor & Introduction -->
        <div class="mb-10 flex flex-col items-center select-none">
            <!-- Luxury Circular Logo Frame with Gold Accent -->
            <div class="relative p-5 rounded-full bg-white/60 backdrop-blur-md border border-[#C5A880]/30 shadow-xl shadow-stone-100/50 transition-all duration-700 hover:scale-105 hover:rotate-2 group">
                <div class="absolute inset-0 rounded-full border border-dashed border-[#C5A880]/50 animate-[spin_40s_linear_infinite] group-hover:border-solid"></div>
                <img src="{{ asset('assets/img/logo.png') }}" alt="BookSpace Logo" class="h-28 w-28 object-contain mx-auto relative z-10 filter drop-shadow-[0_4px_12px_rgba(140,98,57,0.15)]">
            </div>

            <!-- Tracked Brand Name -->
            <div class="mt-6 text-center">
                <span class="font-serif-luxury text-sm tracking-[0.45em] text-[#8C6239] font-bold uppercase block">B O O K S P A C E</span>
                <span class="text-[10px] font-sans font-medium tracking-[0.2em] text-[#2C302E]/40 uppercase block mt-1.5">{{ __('Visual Identity Overhaul') }}</span>
            </div>

            <!-- Micro luxury Divider -->
            <div class="w-16 h-[1px] bg-gradient-to-r from-transparent via-[#C5A880]/60 to-transparent my-6"></div>
        </div>

        <!-- SECTION B: Streamlined Luxury Card -->
        <div class="w-full max-w-xl bg-white/70 backdrop-blur-md border border-white/90 rounded-[2.5rem] p-10 md:p-12 shadow-2xl shadow-stone-200/50 transition-all duration-500 hover:shadow-stone-300/40">
            <!-- Serif Elegant Header -->
            <h1 class="font-serif-luxury text-4xl md:text-5xl text-[#2C302E] mb-5 leading-tight font-medium">
                {{ __('Welcome to BookSpace') }}
            </h1>
            
            <!-- Sleek Modern Description -->
            <p class="text-sm md:text-base text-gray-500/90 leading-relaxed font-normal mb-8 max-w-lg mx-auto">
                {{ __('Library Management System') }}. {{ __('Discover, organize, and immerse yourself in a world of endless reading possibilities with an elegant and soft touch.') }}
            </p>
            
            <!-- High-End Call to Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto bg-[#8C6239] text-[#FAF9F5] hover:bg-[#6F4A25] px-10 py-3.5 rounded-full font-semibold text-sm transition-all duration-300 shadow-md shadow-[#8C6239]/20 hover:-translate-y-0.5 active:translate-y-0">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-[#8C6239] text-[#FAF9F5] hover:bg-[#6F4A25] px-10 py-3.5 rounded-full font-semibold text-sm transition-all duration-300 shadow-md shadow-[#8C6239]/20 hover:-translate-y-0.5 active:translate-y-0">
                        {{ __('Register Now') }}
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto border border-[#8C6239]/50 text-[#8C6239] hover:bg-[#8C6239] hover:text-[#FAF9F5] hover:border-transparent px-10 py-3.5 rounded-full font-semibold text-sm transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0">
                        {{ __('Login') }}
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- Global Footer -->
    <footer class="bg-transparent py-8 px-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-[#2C302E]/60 border-t border-[#C5A880]/10">
        <div class="flex items-center gap-2 select-none">
            <span class="font-serif-luxury font-bold text-sm text-[#8C6239] tracking-wider">BookSpace</span>
        </div>
        <div class="text-[#2C302E]/50">
            &copy; {{ date('Y') }} BookSpace. {{ __('All rights reserved.') }}
        </div>
        <div class="flex items-center gap-4 text-[#2C302E]/50">
            <a href="#" class="transition duration-300 hover:text-[#8C6239]">{{ __('About') }}</a>
            <span>&middot;</span>
            <a href="#" class="transition duration-300 hover:text-[#8C6239]">{{ __('Contact') }}</a>
        </div>
    </footer>
</body>
</html>

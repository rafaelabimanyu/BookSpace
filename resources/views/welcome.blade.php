<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
</head>
<body class="bg-bg-cream text-text-charcoal font-sans antialiased min-h-screen flex flex-col">
    <!-- Header -->
    <header class="w-full py-6 px-8 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-2">
            <svg class="w-8 h-8 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span class="font-display font-bold text-2xl text-primary-rose tracking-wide">BookSpace</span>
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

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-text-charcoal font-semibold hover:text-primary-rose transition">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-text-charcoal font-semibold hover:text-primary-rose transition">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary py-2 px-5 text-sm">{{ __('Register') }}</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col justify-center items-center px-4 relative z-10 text-center">
        <!-- Decorative Background Elements -->
        <div class="absolute top-1/4 left-10 w-32 h-32 bg-secondary-blush rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-1/3 right-10 w-32 h-32 bg-rose-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-32 h-32 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

        <div class="card p-12 max-w-3xl w-full relative backdrop-blur-sm bg-white/80 border-white/40 shadow-xl">
            <h1 class="text-5xl md:text-6xl font-display font-bold text-text-charcoal mb-6 leading-tight">
                {{ __('Welcome to BookSpace') }}
            </h1>
            <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                {{ __('Library Management System') }}. Discover, organize, and immerse yourself in a world of endless reading possibilities with an elegant and soft touch.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary text-lg px-8 py-4">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                        {{ __('Register') }}
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary text-lg px-8 py-4">
                        {{ __('Login') }}
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <style>
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
    </style>
</body>
</html>

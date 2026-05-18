<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <title>{{ config('app.name', 'BookSpace') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-cream text-text-charcoal font-sans antialiased min-h-screen flex flex-col justify-center items-center relative">
    
    <!-- Decorative Blobs -->
    <div class="absolute top-1/4 left-10 w-32 h-32 bg-secondary-blush rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute bottom-1/4 right-10 w-32 h-32 bg-rose-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>

    <div class="card p-10 max-w-md w-full relative backdrop-blur-sm bg-white/90 border-white/40 shadow-xl z-10">
        <div class="text-center mb-8 flex flex-col items-center">
            <a href="/" class="mb-4 inline-block transition-transform duration-300 hover:scale-105 active:scale-95">
                <img src="{{ asset('assets/img/logo.png') }}" alt="BookSpace Logo" class="w-20 h-20 object-contain">
            </a>
            <h1 class="text-4xl font-display font-bold text-primary-rose mb-2">BookSpace</h1>
            <p class="text-gray-500 font-medium">{{ __('Login to your account') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-5">
                <label for="email" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Email') }}</label>
                <input id="email" class="input-field py-3 px-4" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label for="password" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Password') }}</label>
                <input id="password" class="input-field py-3 px-4" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-secondary-blush text-primary-rose shadow-sm focus:ring-primary-rose" name="remember">
                    <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col gap-4">
                <button type="submit" class="btn-primary w-full py-4 text-lg">
                    {{ __('Log in') }}
                </button>
                
                @if (Route::has('password.request'))
                    <a class="text-center text-sm text-gray-500 hover:text-primary-rose font-medium transition" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <style>
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</body>
</html>

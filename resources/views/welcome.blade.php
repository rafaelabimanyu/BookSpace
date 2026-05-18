<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <title>BookSpace - Sanctuary of Books</title>

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
            animation: blob 10s infinite ease-in-out alternate;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(40px, -40px) scale(1.1); }
            100% { transform: translate(-20px, 20px) scale(0.95); }
        }
    </style>
</head>
<body class="bg-bg-cream text-text-charcoal antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- ========================================== -->
    <!-- AMBIENT GLOWING SHAPES (BACKGROUND CORES) -->
    <!-- ========================================== -->
    <div class="absolute top-10 left-10 w-96 h-96 bg-secondary-blush/60 rounded-full filter blur-[100px] animate-blob"></div>
    <div class="absolute top-[80vh] right-10 w-[30rem] h-[30rem] bg-rose-200/30 rounded-full filter blur-[120px] animate-blob animation-delay-2000"></div>
    <div class="absolute top-[180vh] -left-20 w-[35rem] h-[35rem] bg-secondary-blush/50 rounded-full filter blur-[140px] animate-blob animation-delay-4000"></div>
    <div class="absolute top-[280vh] right-20 w-96 h-96 bg-rose-200/30 rounded-full filter blur-[100px] animate-blob"></div>

    <!-- ========================================== -->
    <!-- HEADER (NAVIGATION BAR) -->
    <!-- ========================================== -->
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

    <!-- ========================================== -->
    <!-- SECTION 1: HERO SECTION -->
    <!-- ========================================== -->
    <main class="min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-6 pb-20 relative z-10 text-center animate-fade-in-up">
        <!-- Central Logo Anchor & Introduction -->
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

        <!-- Streamlined Glassmorphism Card -->
        <div class="w-full max-w-xl bg-white/75 backdrop-blur-md border border-white/50 rounded-[2.5rem] p-10 md:p-12 shadow-2xl shadow-rose-100/30 transition-premium hover:shadow-rose-100/50 mb-10">
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

        <!-- Elegant Scroll Down Indicator -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-2 select-none z-10 cursor-pointer" onclick="document.getElementById('statistics').scrollIntoView({ behavior: 'smooth' })">
            <span class="text-[9px] font-sans font-bold uppercase tracking-[0.25em] text-primary-rose/60 animate-pulse">{{ __('Scroll Down') }}</span>
            <div class="w-6 h-10 rounded-full border-2 border-primary-rose/30 flex justify-center p-1.5 backdrop-blur-xs">
                <div class="w-1 h-2 bg-primary-rose rounded-full animate-bounce"></div>
            </div>
        </div>
    </main>

    <!-- ========================================== -->
    <!-- SECTION 2: BOOKSPACE STATISTICS (COUNTER) -->
    <!-- ========================================== -->
    <section id="statistics" class="w-full max-w-5xl mx-auto px-6 py-20 relative z-10 scroll-mt-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <!-- Stat Item 1 -->
            <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-[2.25rem] shadow-xl hover:shadow-rose-100/40 transition-premium hover:-translate-y-1.5">
                <span class="font-display text-4xl md:text-5xl text-primary-rose font-bold block mb-2">12,000+</span>
                <span class="text-xs font-sans font-bold tracking-wider text-text-charcoal/50 uppercase">{{ __('Koleksi Buku') }}</span>
            </div>
            <!-- Stat Item 2 -->
            <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-[2.25rem] shadow-xl hover:shadow-rose-100/40 transition-premium hover:-translate-y-1.5">
                <span class="font-display text-4xl md:text-5xl text-primary-rose font-bold block mb-2">5,000+</span>
                <span class="text-xs font-sans font-bold tracking-wider text-text-charcoal/50 uppercase">{{ __('Anggota Aktif') }}</span>
            </div>
            <!-- Stat Item 3 -->
            <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-[2.25rem] shadow-xl hover:shadow-rose-100/40 transition-premium hover:-translate-y-1.5">
                <span class="font-display text-4xl md:text-5xl text-primary-rose font-bold block mb-2">40+</span>
                <span class="text-xs font-sans font-bold tracking-wider text-text-charcoal/50 uppercase">{{ __('Kategori Literasi') }}</span>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 3: TRENDING & FEATURED BOOKS -->
    <!-- ========================================== -->
    <section class="w-full max-w-6xl mx-auto px-6 py-20 relative z-10">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl md:text-4xl text-text-charcoal font-bold mb-3 tracking-wide">{{ __('Katalog Terpopuler') }}</h2>
            <p class="text-xs font-sans font-bold tracking-widest text-primary-rose uppercase">{{ __('Curated Literary Masterpieces') }}</p>
            <div class="w-16 h-[1.5px] bg-gradient-to-r from-transparent via-primary-rose/40 to-transparent mx-auto mt-4"></div>
        </div>

        <!-- Grid of 4 Book Covers -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Book 1 -->
            <div class="group flex flex-col items-center">
                <!-- Cover Frame -->
                <div class="relative w-44 h-64 rounded-2xl overflow-hidden shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl shadow-rose-200/40 cursor-pointer">
                    <!-- Spine/Cover Mockup utilizing premium color gradients -->
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-400 to-pink-600 p-6 flex flex-col justify-between text-white select-none">
                        <!-- Spine shadow for realistic 3D feel -->
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-black/15"></div>
                        
                        <div class="text-[9px] font-sans font-bold uppercase tracking-widest text-rose-100">Bestseller</div>
                        <div class="space-y-1">
                            <span class="font-display font-bold text-sm block leading-tight text-white">The Horizon of Knowledge</span>
                            <span class="text-[9px] font-sans font-semibold text-rose-100 block">Arthur Pendelton</span>
                        </div>
                        <div class="text-[8px] font-sans font-bold tracking-wider text-rose-200">2026 Edition</div>
                    </div>
                    
                    <!-- Hover overlay containing Lihat Detail button -->
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('login') }}" class="bg-white text-primary-rose font-display font-bold text-[10px] uppercase tracking-wider px-5 py-2.5 rounded-xl hover:bg-primary-rose hover:text-white transition duration-200 shadow-sm">{{ __('Lihat Detail') }}</a>
                    </div>
                </div>
                <span class="mt-4 font-display font-bold text-sm text-text-charcoal leading-tight text-center truncate w-full px-2">{{ __('The Horizon of Knowledge') }}</span>
                <span class="text-xs text-text-charcoal/50 mt-1 font-semibold">{{ __('Arthur Pendelton') }}</span>
            </div>

            <!-- Book 2 -->
            <div class="group flex flex-col items-center">
                <div class="relative w-44 h-64 rounded-2xl overflow-hidden shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl shadow-rose-200/40 cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#35524F] to-[#253D3A] p-6 flex flex-col justify-between text-white select-none">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-black/15"></div>
                        
                        <div class="text-[9px] font-sans font-bold uppercase tracking-widest text-teal-200">Recommended</div>
                        <div class="space-y-1">
                            <span class="font-display font-bold text-sm block leading-tight text-white">Serenade of Leaves</span>
                            <span class="text-[9px] font-sans font-semibold text-teal-200 block">Clara Montgomery</span>
                        </div>
                        <div class="text-[8px] font-sans font-bold tracking-wider text-teal-300">Classic Series</div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('login') }}" class="bg-white text-primary-rose font-display font-bold text-[10px] uppercase tracking-wider px-5 py-2.5 rounded-xl hover:bg-primary-rose hover:text-white transition duration-200 shadow-sm">{{ __('Lihat Detail') }}</a>
                    </div>
                </div>
                <span class="mt-4 font-display font-bold text-sm text-text-charcoal leading-tight text-center truncate w-full px-2">{{ __('Serenade of Leaves') }}</span>
                <span class="text-xs text-text-charcoal/50 mt-1 font-semibold">{{ __('Clara Montgomery') }}</span>
            </div>

            <!-- Book 3 -->
            <div class="group flex flex-col items-center">
                <div class="relative w-44 h-64 rounded-2xl overflow-hidden shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl shadow-rose-200/40 cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 to-purple-900 p-6 flex flex-col justify-between text-white select-none">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-black/15"></div>
                        
                        <div class="text-[9px] font-sans font-bold uppercase tracking-widest text-purple-200">Trending</div>
                        <div class="space-y-1">
                            <span class="font-display font-bold text-sm block leading-tight text-white">Symphony of the Mind</span>
                            <span class="text-[9px] font-sans font-semibold text-purple-200 block">Dr. Julian Vance</span>
                        </div>
                        <div class="text-[8px] font-sans font-bold tracking-wider text-purple-300">Science & Philosophy</div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('login') }}" class="bg-white text-primary-rose font-display font-bold text-[10px] uppercase tracking-wider px-5 py-2.5 rounded-xl hover:bg-primary-rose hover:text-white transition duration-200 shadow-sm">{{ __('Lihat Detail') }}</a>
                    </div>
                </div>
                <span class="mt-4 font-display font-bold text-sm text-text-charcoal leading-tight text-center truncate w-full px-2">{{ __('Symphony of the Mind') }}</span>
                <span class="text-xs text-text-charcoal/50 mt-1 font-semibold">{{ __('Dr. Julian Vance') }}</span>
            </div>

            <!-- Book 4 -->
            <div class="group flex flex-col items-center">
                <div class="relative w-44 h-64 rounded-2xl overflow-hidden shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl shadow-rose-200/40 cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-800 to-amber-950 p-6 flex flex-col justify-between text-white select-none">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-black/15"></div>
                        
                        <div class="text-[9px] font-sans font-bold uppercase tracking-widest text-amber-200">Award Winner</div>
                        <div class="space-y-1">
                            <span class="font-display font-bold text-sm block leading-tight text-white">Echoes of History</span>
                            <span class="text-[9px] font-sans font-semibold text-amber-200 block">Beatrice Thorne</span>
                        </div>
                        <div class="text-[8px] font-sans font-bold tracking-wider text-amber-300">Historical Fiction</div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('login') }}" class="bg-white text-primary-rose font-display font-bold text-[10px] uppercase tracking-wider px-5 py-2.5 rounded-xl hover:bg-primary-rose hover:text-white transition duration-200 shadow-sm">{{ __('Lihat Detail') }}</a>
                    </div>
                </div>
                <span class="mt-4 font-display font-bold text-sm text-text-charcoal leading-tight text-center truncate w-full px-2">{{ __('Echoes of History') }}</span>
                <span class="text-xs text-text-charcoal/50 mt-1 font-semibold">{{ __('Beatrice Thorne') }}</span>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 4: OUR MODERN FEATURES -->
    <!-- ========================================== -->
    <section class="w-full max-w-6xl mx-auto px-6 py-20 relative z-10">
        <div class="text-center mb-16">
            <h2 class="font-display text-3xl md:text-4xl text-text-charcoal font-bold mb-3 tracking-wide">{{ __('Keunggulan Sistem') }}</h2>
            <p class="text-xs font-sans font-bold tracking-widest text-primary-rose uppercase">{{ __('State-of-the-Art Features') }}</p>
            <div class="w-16 h-[1.5px] bg-gradient-to-r from-transparent via-primary-rose/40 to-transparent mx-auto mt-4"></div>
        </div>

        <!-- 3 Column Feature Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-[2rem] shadow-xl hover:shadow-rose-100/40 transition-premium hover:-translate-y-1.5 flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-full bg-secondary-blush border border-primary-rose/25 flex items-center justify-center mb-6">
                    <!-- Sirkulasi Icon (Heroicons Calendar/Switch) -->
                    <svg class="w-6 h-6 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h3 class="font-display font-bold text-lg text-text-charcoal mb-3">{{ __('Sirkulasi Mandiri') }}</h3>
                <p class="text-xs text-text-charcoal/60 leading-relaxed font-semibold">
                    {{ __('Proses peminjaman dan pengembalian buku yang transparan dan mandiri, terintegrasi secara dinamis untuk Admin, Petugas, dan Peminjam.') }}
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-[2rem] shadow-xl hover:shadow-rose-100/40 transition-premium hover:-translate-y-1.5 flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-full bg-secondary-blush border border-primary-rose/25 flex items-center justify-center mb-6">
                    <!-- Multi language Icon (Heroicons Globe) -->
                    <svg class="w-6 h-6 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 7.363 16.5 3 18.062"></path>
                    </svg>
                </div>
                <h3 class="font-display font-bold text-lg text-text-charcoal mb-3">{{ __('Akses Multi-Bahasa') }}</h3>
                <p class="text-xs text-text-charcoal/60 leading-relaxed font-semibold">
                    {{ __('Dukungan penuh sistem dwi-bahasa (Indonesia dan Inggris / ID-EN) untuk menghadirkan kenyamanan akses literasi bagi semua kalangan.') }}
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-[2rem] shadow-xl hover:shadow-rose-100/40 transition-premium hover:-translate-y-1.5 flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-full bg-secondary-blush border border-primary-rose/25 flex items-center justify-center mb-6">
                    <!-- Responsive Catalog Icon (Heroicons DeviceMobile) -->
                    <svg class="w-6 h-6 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-display font-bold text-lg text-text-charcoal mb-3">{{ __('Katalog Responsif') }}</h3>
                <p class="text-xs text-text-charcoal/60 leading-relaxed font-semibold">
                    {{ __('Cari, temukan, dan simpan daftar katalog buku favoritmu secara instan dari perangkat mobile maupun desktop kapan saja, di mana saja.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 5: FOOTER MEWAH -->
    <!-- ========================================== -->
    <footer class="bg-white/60 backdrop-blur-md border-t border-secondary-blush py-12 px-8 relative z-10">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 text-left">
            <!-- Col 1: Logo & Tagline -->
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="BookSpace Logo" class="h-8 w-auto object-contain filter grayscale opacity-70 select-none">
                    <span class="font-display font-bold text-lg text-text-charcoal/70 tracking-wider">BookSpace</span>
                </div>
                <p class="text-xs text-text-charcoal/50 leading-relaxed max-w-sm font-semibold">
                    {{ __('BookSpace menghadirkan ekosistem perpustakaan digital terintegrasi yang modern, mewah, dan intuitif demi kenyamanan dan perluasan akses literasi Anda.') }}
                </p>
            </div>
            
            <!-- Col 2: Hubungi Kami -->
            <div class="space-y-4">
                <h4 class="font-display font-bold text-sm text-text-charcoal/80 uppercase tracking-wider">{{ __('Hubungi Kami') }}</h4>
                <ul class="text-xs text-text-charcoal/50 space-y-2 font-semibold">
                    <li>Jl. Perpustakaan Raya No. 42</li>
                    <li>support@bookspace.library</li>
                    <li>+62 (21) 555-0199</li>
                </ul>
            </div>

            <!-- Col 3: Media Sosial -->
            <div class="space-y-4">
                <h4 class="font-display font-bold text-sm text-text-charcoal/80 uppercase tracking-wider">{{ __('Media Sosial') }}</h4>
                <div class="flex items-center gap-4">
                    <a href="#" class="w-8 h-8 rounded-full bg-secondary-blush border border-primary-rose/25 flex items-center justify-center text-primary-rose hover:bg-primary-rose hover:text-white transition duration-200">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-secondary-blush border border-primary-rose/25 flex items-center justify-center text-primary-rose hover:bg-primary-rose hover:text-white transition duration-200">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sub Footer / Copyright -->
        <div class="max-w-6xl mx-auto pt-8 border-t border-secondary-blush/30 flex flex-col md:flex-row justify-between items-center text-[#2C302E]/40 font-semibold gap-4">
            <div>
                &copy; {{ date('Y') }} BookSpace. {{ __('All rights reserved.') }}
            </div>
            <div class="flex items-center gap-1 text-[11px]">
                <span>{{ __('Made with') }}</span>
                <svg class="w-3.5 h-3.5 text-primary-rose fill-current animate-pulse" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                <span>{{ __('in BookSpace') }}</span>
            </div>
        </div>
    </footer>
</body>
</html>

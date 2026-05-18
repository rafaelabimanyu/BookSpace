@extends('layouts.bookspace')

@section('title', __('System Guide'))

@section('header_title', __('System Guide'))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start w-full">
    
    <!-- Sticky Quick Navigation Index (Col 1) -->
    <aside class="lg:col-span-1 sticky top-24 hidden lg:block z-20">
        <div class="p-6 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md transition-premium hover:shadow-2xl">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 font-display flex items-center gap-2">
                <span>📍</span> {{ __('Quick Navigation') }}
            </h3>
            <nav class="space-y-2">
                <!-- Shared Petugas Sections -->
                <div class="text-[10px] font-bold text-primary-rose/70 uppercase tracking-wider mb-2 mt-4 first:mt-0 font-display">
                    {{ __('PETUGAS SECTOR') }}
                </div>
                <a href="#circulation" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1.5">
                    <span class="mr-2 text-sm">📖</span> {{ __('Circulation Management') }}
                </a>
                <a href="#settlements" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1.5">
                    <span class="mr-2 text-sm">💸</span> {{ __('Fine Settlements') }}
                </a>
                <a href="#reviews" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1.5">
                    <span class="mr-2 text-sm">💬</span> {{ __('Review Moderation') }}
                </a>

                <!-- Admin Specific Sections -->
                @if(auth()->user()->role === 'admin')
                    <div class="text-[10px] font-bold text-primary-rose/70 uppercase tracking-wider mb-2 mt-6 font-display">
                        {{ __('ADMIN SECTOR') }}
                    </div>
                    <a href="#users" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1.5">
                        <span class="mr-2 text-sm">👥</span> {{ __('User Management Administration') }}
                    </a>
                    <a href="#settings" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1.5">
                        <span class="mr-2 text-sm">⚙️</span> {{ __('System Settings Adjustments') }}
                    </a>
                    <a href="#analytics" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1.5">
                        <span class="mr-2 text-sm">📊</span> {{ __('Financial Reports & Analytics') }}
                    </a>
                @endif
            </nav>
        </div>
    </aside>

    <!-- Main Content Area (Col 3) -->
    <main class="col-span-1 lg:col-span-3 space-y-8">
        
        <!-- Header Hero Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-secondary-blush/70 via-white/80 to-white p-8 rounded-3xl border border-primary-rose/25 shadow-xl shadow-rose-100/30 backdrop-blur-md flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 transition-premium hover:shadow-2xl">
            <div class="space-y-2">
                <h1 class="text-3xl font-display font-bold text-text-charcoal leading-tight">
                    {{ __('Operational Guide Center') }}
                </h1>
                <p class="text-xs font-semibold text-gray-500 max-w-xl leading-relaxed">
                    {{ __('Step-by-step procedures for staff & administrators.') }}
                </p>
            </div>
            <div class="text-6xl select-none animate-pulse">💡</div>
        </div>

        <!-- ================= PETUGAS SECTOR ================= -->
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-2">
                <span class="h-[2px] bg-primary-rose/30 flex-1"></span>
                <span class="text-xs font-bold font-display text-primary-rose uppercase tracking-widest px-4 py-1.5 bg-secondary-blush/60 border border-primary-rose/20 rounded-full shadow-xs">
                    {{ __('PETUGAS SECTOR') }}
                </span>
                <span class="h-[2px] bg-primary-rose/30 flex-1"></span>
            </div>

            <!-- Section 1: Circulation Management -->
            <section id="circulation" class="p-8 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md scroll-mt-24 transition-premium hover:shadow-2xl">
                <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-4 flex items-center gap-3">
                    <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">📖</span>
                    {{ __('Circulation Management') }}
                </h3>
                <p class="text-xs text-gray-500 font-semibold mb-6">
                    {{ __('Daily manual circulation management guides.') }}
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl flex flex-col justify-between transition-premium hover:bg-white/80">
                        <div>
                            <div class="font-bold text-text-charcoal text-sm mb-2 font-display">1. {{ __('Record new book checkout') }}</div>
                            <p class="text-[11px] text-gray-500 font-semibold leading-relaxed">
                                {{ __('Configure lending limits, default durations, and active overdue penalty metrics globally.') }}
                            </p>
                        </div>
                    </div>
                    <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl flex flex-col justify-between transition-premium hover:bg-white/80">
                        <div>
                            <div class="font-bold text-text-charcoal text-sm mb-2 font-display">2. {{ __('Return Deadline') }}</div>
                            <p class="text-[11px] text-gray-500 font-semibold leading-relaxed">
                                {{ __('Default duration in days for every checkout reservation before being marked overdue.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 2: Fine Settlements -->
            <section id="settlements" class="p-8 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md scroll-mt-24 transition-premium hover:shadow-2xl">
                <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-4 flex items-center gap-3">
                    <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">💸</span>
                    {{ __('Fine Settlements') }}
                </h3>
                <p class="text-xs text-gray-500 font-semibold mb-6">
                    {{ __('Monitor library defaults, calculate daily late penalty ratios, and verify settles.') }}
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-5 bg-amber-50/50 border border-amber-100/80 rounded-2xl flex items-start gap-4 transition-premium hover:bg-amber-50 md:col-span-2">
                        <span class="text-amber-500 text-2xl">💳</span>
                        <div>
                            <h4 class="font-bold text-amber-800 text-sm mb-2 font-display">{{ __('Verify Payment') }}</h4>
                            <p class="text-amber-700/90 text-[11px] font-semibold leading-relaxed">
                                {{ __('Monitor library defaults, calculate daily late penalty ratios, and verify settles.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Review Moderation -->
            <section id="reviews" class="p-8 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md scroll-mt-24 transition-premium hover:shadow-2xl">
                <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-4 flex items-center gap-3">
                    <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">💬</span>
                    {{ __('Review Moderation') }}
                </h3>
                <p class="text-xs text-gray-500 font-semibold mb-6">
                    {{ __('Review Moderation') }}
                </p>
                <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl font-semibold text-xs text-gray-500 leading-relaxed transition-premium hover:bg-white/80">
                    {{ __('Be the first to share your thoughts on this book!') }}
                </div>
            </section>
        </div>

        <!-- ================= ADMIN SECTOR ================= -->
        @if(auth()->user()->role === 'admin')
            <div class="space-y-6 pt-6 border-t border-secondary-blush/40">
                <div class="flex items-center gap-2 mb-2">
                    <span class="h-[2px] bg-primary-rose/30 flex-1"></span>
                    <span class="text-xs font-bold font-display text-primary-rose uppercase tracking-widest px-4 py-1.5 bg-secondary-blush/60 border border-primary-rose/20 rounded-full shadow-xs">
                        {{ __('ADMIN SECTOR') }}
                    </span>
                    <span class="h-[2px] bg-primary-rose/30 flex-1"></span>
                </div>

                <!-- Section 4: User Management -->
                <section id="users" class="p-8 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md scroll-mt-24 transition-premium hover:shadow-2xl">
                    <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-4 flex items-center gap-3">
                        <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">👥</span>
                        {{ __('User Management Administration') }}
                    </h3>
                    <p class="text-xs text-gray-500 font-semibold mb-6">
                        {{ __('Manage profiles, role levels, and authorization scopes.') }}
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl transition-premium hover:bg-white/80">
                            <p class="text-xs text-gray-600 font-semibold leading-relaxed">
                                {{ __('User account created successfully!') }}
                            </p>
                        </div>
                        <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl transition-premium hover:bg-white/80">
                            <p class="text-xs text-gray-600 font-semibold leading-relaxed">
                                {{ __('User account updated successfully!') }}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 5: Settings Adjustments -->
                <section id="settings" class="p-8 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md scroll-mt-24 transition-premium hover:shadow-2xl">
                    <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-4 flex items-center gap-3">
                        <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">⚙️</span>
                        {{ __('System Settings Adjustments') }}
                    </h3>
                    <p class="text-xs text-gray-500 font-semibold mb-6">
                        {{ __('Library Control Panel') }}
                    </p>
                    <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl font-semibold text-xs text-gray-600 leading-relaxed transition-premium hover:bg-white/80">
                        <p class="leading-relaxed">
                            {{ __('Configure lending limits, default durations, and active overdue penalty metrics globally.') }}
                        </p>
                    </div>
                </section>

                <!-- Section 6: Financial Reports -->
                <section id="analytics" class="p-8 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md scroll-mt-24 transition-premium hover:shadow-2xl">
                    <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-4 flex items-center gap-3">
                        <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">📊</span>
                        {{ __('Financial Reports & Analytics') }}
                    </h3>
                    <p class="text-xs text-gray-500 font-semibold mb-6">
                        {{ __('Select filters below to generate custom circulation timeline reports.') }}
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl transition-premium hover:bg-white/80">
                            <div class="font-bold text-text-charcoal text-xs mb-1 font-display">{{ __('Library Circulation Report') }}</div>
                            <p class="text-[10px] text-gray-500 leading-normal">
                                {{ __('Select filters below to generate custom circulation timeline reports.') }}
                            </p>
                        </div>
                        <div class="p-5 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl transition-premium hover:bg-white/80">
                            <div class="font-bold text-text-charcoal text-xs mb-1 font-display">{{ __('Library Reports') }}</div>
                            <p class="text-[10px] text-gray-500 leading-normal">
                                {{ __('Generated on') }}
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        @endif

    </main>
</div>
@endsection

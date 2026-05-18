@extends('layouts.bookspace')

@section('title', __('System Guide'))

@section('header_title', __('System Guide'))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- Sticky Quick Navigation Index (Col 1) -->
    <div class="lg:col-span-1">
        <div class="sticky top-24 p-6 bg-white/80 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.12)] rounded-3xl backdrop-blur-md">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 font-display">
                {{ __('Quick Navigation') }}
            </h3>
            <nav class="space-y-2">
                <!-- Shared Petugas Sections -->
                <div class="text-[10px] font-bold text-primary-rose/70 uppercase tracking-wider mb-2 mt-4 first:mt-0 font-display">
                    {{ __('PETUGAS SECTOR') }}
                </div>
                <a href="#circulation" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                    📖 {{ __('Circulation Management') }}
                </a>
                <a href="#settlements" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                    💸 {{ __('Fine Settlements') }}
                </a>
                <a href="#reviews" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                    💬 {{ __('Review Moderation') }}
                </a>

                <!-- Admin Specific Sections -->
                @if(auth()->user()->role === 'admin')
                    <div class="text-[10px] font-bold text-primary-rose/70 uppercase tracking-wider mb-2 mt-6 font-display">
                        {{ __('ADMIN SECTOR') }}
                    </div>
                    <a href="#users" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                        👥 {{ __('User Management Administration') }}
                    </a>
                    <a href="#settings" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                        ⚙️ {{ __('System Settings Adjustments') }}
                    </a>
                    <a href="#analytics" class="flex items-center px-4 py-2 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                        📊 {{ __('Financial Reports & Analytics') }}
                    </a>
                @endif
            </nav>
        </div>
    </div>

    <!-- Main Content Area (Col 3) -->
    <div class="lg:col-span-3 space-y-8">
        
        <!-- Header Hero Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-secondary-blush to-white p-8 rounded-3xl border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.15)] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <h1 class="text-3xl font-display font-bold text-text-charcoal leading-tight">
                    {{ __('Operational Guide Center') }}
                </h1>
                <p class="text-xs font-semibold text-gray-500 mt-2 max-w-xl">
                    {{ __('Step-by-step procedures for staff & administrators.') }}
                </p>
            </div>
            <span class="text-5xl select-none">💡</span>
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
            <section id="circulation" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
                <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                    <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">📖</span>
                    {{ __('Circulation Management') }}
                </h3>
                <p class="text-xs text-gray-500 font-semibold mb-6">
                    {{ __('Daily manual circulation management guides.') }}
                </p>
                <div class="space-y-4 font-semibold text-xs text-gray-600 leading-relaxed">
                    <div class="p-4 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl">
                        <div class="font-bold text-text-charcoal mb-1">1. {{ __('Record new book checkout') }}</div>
                        <p class="text-[11px] text-gray-500 leading-snug">
                            {{ __('Configure lending limits, default durations, and active overdue penalty metrics globally.') }}
                        </p>
                    </div>
                    <div class="p-4 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl">
                        <div class="font-bold text-text-charcoal mb-1">2. {{ __('Return Deadline') }}</div>
                        <p class="text-[11px] text-gray-500 leading-snug">
                            {{ __('Default duration in days for every checkout reservation before being marked overdue.') }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 2: Fine Settlements -->
            <section id="settlements" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
                <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                    <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">💸</span>
                    {{ __('Fine Settlements') }}
                </h3>
                <p class="text-xs text-gray-500 font-semibold mb-6">
                    {{ __('Monitor library defaults, calculate daily late penalty ratios, and verify settles.') }}
                </p>
                <div class="space-y-4 font-semibold text-xs text-gray-600 leading-relaxed">
                    <div class="p-4 bg-amber-50/50 border border-amber-100/80 rounded-2xl flex items-start gap-3">
                        <span class="text-amber-500 text-lg">💳</span>
                        <div>
                            <h4 class="font-bold text-amber-800 text-sm mb-0.5">{{ __('Verify Payment') }}</h4>
                            <p class="text-amber-700/90 text-[11px] leading-snug">
                                {{ __('Monitor library defaults, calculate daily late penalty ratios, and verify settles.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Review Moderation -->
            <section id="reviews" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
                <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                    <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">💬</span>
                    {{ __('Review Moderation') }}
                </h3>
                <p class="text-xs text-gray-500 font-semibold mb-6">
                    {{ __('Review Moderation') }}
                </p>
                <div class="p-4 bg-bg-cream/40 border border-secondary-blush/40 rounded-2xl font-semibold text-xs text-gray-500 leading-relaxed">
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
                <section id="users" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
                    <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                        <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">👥</span>
                        {{ __('User Management Administration') }}
                    </h3>
                    <p class="text-xs text-gray-500 font-semibold mb-6">
                        {{ __('Manage profiles, role levels, and authorization scopes.') }}
                    </p>
                    <div class="space-y-4 font-semibold text-xs text-gray-600 leading-relaxed">
                        <p>
                            {{ __('User account created successfully!') }}
                        </p>
                        <p>
                            {{ __('User account updated successfully!') }}
                        </p>
                    </div>
                </section>

                <!-- Section 5: Settings Adjustments -->
                <section id="settings" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
                    <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                        <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">⚙️</span>
                        {{ __('System Settings Adjustments') }}
                    </h3>
                    <p class="text-xs text-gray-500 font-semibold mb-6">
                        {{ __('Library Control Panel') }}
                    </p>
                    <div class="space-y-4 font-semibold text-xs text-gray-600 leading-relaxed">
                        <p>
                            {{ __('Configure lending limits, default durations, and active overdue penalty metrics globally.') }}
                        </p>
                    </div>
                </section>

                <!-- Section 6: Financial Reports -->
                <section id="analytics" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
                    <h3 class="text-lg font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                        <span class="p-1.5 bg-secondary-blush/60 rounded-xl text-primary-rose">📊</span>
                        {{ __('Financial Reports & Analytics') }}
                    </h3>
                    <p class="text-xs text-gray-500 font-semibold mb-6">
                        {{ __('Select filters below to generate custom circulation timeline reports.') }}
                    </p>
                    <div class="space-y-4 font-semibold text-xs text-gray-600 leading-relaxed">
                        <p>
                            {{ __('Library Circulation Report') }}
                        </p>
                    </div>
                </section>
            </div>
        @endif

    </div>
</div>
@endsection

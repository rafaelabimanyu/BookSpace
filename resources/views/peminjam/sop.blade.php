@extends('layouts.bookspace')

@section('title', __('SOP Guide'))

@section('header_title', __('SOP Guide'))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- Sticky Quick Navigation Index (Col 1 on large screens) -->
    <div class="lg:col-span-1">
        <div class="sticky top-24 p-6 bg-white/80 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.12)] rounded-3xl backdrop-blur-md">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 font-display">
                {{ __('Quick Navigation') }}
            </h3>
            <nav class="space-y-2">
                <a href="#workflow" class="flex items-center px-4 py-2.5 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                    <svg class="w-4 h-4 mr-2 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    {{ __('Tata Cara Peminjaman') }}
                </a>
                <a href="#limits" class="flex items-center px-4 py-2.5 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                    <svg class="w-4 h-4 mr-2 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"></path></svg>
                    {{ __('Aturan & Batas Peminjaman') }}
                </a>
                <a href="#fines" class="flex items-center px-4 py-2.5 rounded-xl text-xs font-bold text-text-charcoal hover:bg-secondary-blush/60 hover:text-primary-rose transition-premium hover:translate-x-1">
                    <svg class="w-4 h-4 mr-2 text-primary-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('Sistem Kebijakan Denda') }}
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content Area (Col 3 on large screens) -->
    <div class="lg:col-span-3 space-y-8">
        
        <!-- Header Hero Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-secondary-blush to-white p-8 rounded-3xl border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.15)] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <h1 class="text-3xl font-display font-bold text-text-charcoal leading-tight">
                    {{ __('Interactive SOP Guide for Borrowers') }}
                </h1>
                <p class="text-xs font-semibold text-gray-500 mt-2 max-w-xl">
                    {{ __('Ambang batas peminjaman anggota dikonfigurasi secara global.') }}
                </p>
            </div>
            <span class="text-5xl select-none">📖</span>
        </div>

        <!-- Section 1: Workflow Timeline -->
        <section id="workflow" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
            <h2 class="text-xl font-display font-bold text-text-charcoal mb-8 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                <span class="p-2 bg-secondary-blush/60 rounded-xl text-primary-rose">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
                {{ __('Tata Cara Peminjaman') }}
            </h2>

            <div class="relative pl-8 border-l border-primary-rose/30 space-y-8">
                <!-- Step 1 -->
                <div class="relative">
                    <span class="absolute -left-[45px] top-0 flex items-center justify-center w-8 h-8 rounded-full bg-primary-rose border-4 border-white text-white font-bold text-xs shadow-sm">
                        1
                    </span>
                    <h3 class="text-base font-display font-bold text-text-charcoal mb-1">
                        {{ __('Browse & Search') }}
                    </h3>
                    <p class="text-gray-500 font-semibold text-xs leading-relaxed">
                        {{ __('Find your desired books in the catalog.') }}
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <span class="absolute -left-[45px] top-0 flex items-center justify-center w-8 h-8 rounded-full bg-primary-rose border-4 border-white text-white font-bold text-xs shadow-sm">
                        2
                    </span>
                    <h3 class="text-base font-display font-bold text-text-charcoal mb-1">
                        {{ __('Reserve & Checkout') }}
                    </h3>
                    <p class="text-gray-500 font-semibold text-xs leading-relaxed">
                        {{ __('Click the borrow button to claim the book.') }}
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <span class="absolute -left-[45px] top-0 flex items-center justify-center w-8 h-8 rounded-full bg-primary-rose border-4 border-white text-white font-bold text-xs shadow-sm">
                        3
                    </span>
                    <h3 class="text-base font-display font-bold text-text-charcoal mb-1">
                        {{ __('Read & Return') }}
                    </h3>
                    <p class="text-gray-500 font-semibold text-xs leading-relaxed">
                        {{ __('Return the book within :days days window.', ['days' => $borrowDuration]) }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Section 2: Lending Limits -->
        <section id="limits" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
            <h2 class="text-xl font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                <span class="p-2 bg-secondary-blush/60 rounded-xl text-primary-rose">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"></path></svg>
                </span>
                {{ __('Aturan & Batas Peminjaman') }}
            </h2>
            <p class="text-xs font-semibold text-gray-500 mb-6">
                {{ __('Borrower lending thresholds configured globally.') }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Limit Card 1 -->
                <div class="card p-5 bg-secondary-blush/20 border border-secondary-blush/50 flex flex-col justify-between hover:scale-[1.03] transition-premium shadow-xs">
                    <div>
                        <span class="text-2xl mb-3 block">📚</span>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                            {{ __('Max concurrent books') }}
                        </h4>
                        <p class="text-[10px] text-gray-500 font-semibold leading-snug">
                            {{ __('Max simultaneous books a member can hold.') }}
                        </p>
                    </div>
                    <div class="text-2xl font-display font-bold text-primary-rose mt-4">
                        {{ $maxBooks }} {{ __('Books') }}
                    </div>
                </div>

                <!-- Limit Card 2 -->
                <div class="card p-5 bg-secondary-blush/20 border border-secondary-blush/50 flex flex-col justify-between hover:scale-[1.03] transition-premium shadow-xs">
                    <div>
                        <span class="text-2xl mb-3 block">⏱️</span>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                            {{ __('Standard lending window') }}
                        </h4>
                        <p class="text-[10px] text-gray-500 font-semibold leading-snug">
                            {{ __('Default duration in days for every checkout reservation before being marked overdue.') }}
                        </p>
                    </div>
                    <div class="text-2xl font-display font-bold text-primary-rose mt-4">
                        {{ $borrowDuration }} {{ __('Days') }}
                    </div>
                </div>

                <!-- Limit Card 3 -->
                <div class="card p-5 bg-secondary-blush/20 border border-secondary-blush/50 flex flex-col justify-between hover:scale-[1.03] transition-premium shadow-xs">
                    <div>
                        <span class="text-2xl mb-3 block">💸</span>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                            {{ __('Overdue fee rate') }}
                        </h4>
                        <p class="text-[10px] text-gray-500 font-semibold leading-snug">
                            {{ __('Daily fine accrued per late book.') }}
                        </p>
                    </div>
                    <div class="text-2xl font-display font-bold text-primary-rose mt-4">
                        Rp {{ number_format($dailyFine, 0, ',', '.') }} <span class="text-xs text-gray-400 font-bold">/ {{ __('Day') }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Fine Policy & Calculator -->
        <section id="fines" class="card p-8 bg-white/95 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.1)] rounded-3xl scroll-mt-24">
            <h2 class="text-xl font-display font-bold text-text-charcoal mb-4 border-b border-secondary-blush/40 pb-3 flex items-center gap-2">
                <span class="p-2 bg-secondary-blush/60 rounded-xl text-primary-rose">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                {{ __('Sistem Kebijakan Denda') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                
                <!-- Info block -->
                <div class="space-y-4 font-semibold text-xs leading-relaxed text-gray-600">
                    <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-3">
                        <span class="text-rose-500 text-lg">⚠️</span>
                        <div>
                            <h4 class="font-bold text-rose-800 text-sm mb-0.5">{{ __('Late Return Default') }}</h4>
                            <p class="text-rose-700 leading-snug">
                                {{ __('Accrued penalty amount (in IDR) calculated dynamically per overdue day.') }}
                            </p>
                        </div>
                    </div>
                    <p>
                        {{ __('Monitor library defaults, calculate daily late penalty ratios, and verify settles.') }}
                    </p>
                    <p>
                        {{ __('Carry your virtual member identity to access library checkout stations.') }}
                    </p>
                </div>

                <!-- Interactive Late Fee Simulator -->
                <div class="card p-6 bg-secondary-blush/20 border border-secondary-blush/50 shadow-sm rounded-3xl" x-data="{ days: 1, rate: {{ $dailyFine }} }">
                    <h3 class="text-sm font-bold font-display text-text-charcoal mb-4 flex items-center gap-1.5">
                        <span>🧮</span> {{ __('Fine Calculator') }}
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                                {{ __('Enter overdue days') }}
                            </label>
                            <input 
                                type="number" 
                                min="0" 
                                x-model.number="days"
                                class="input-field py-2.5 px-4 text-sm"
                                placeholder="{{ __('Days Overdue') }}"
                            >
                        </div>

                        <div class="pt-4 border-t border-secondary-blush/40 flex justify-between items-center">
                            <span class="text-xs font-bold text-gray-500">
                                {{ __('Estimated Late Fee') }}:
                            </span>
                            <span class="text-xl font-display font-extrabold text-primary-rose" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(Math.max(0, days) * rate)">
                                Rp 0
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection

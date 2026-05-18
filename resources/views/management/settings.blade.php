@extends('layouts.bookspace')

@section('title', __('System Settings'))
@section('header_title', __('System Settings'))

@section('content')
<div class="max-w-3xl space-y-8 animate-fadeIn">
    
    <!-- Top Row Header -->
    <div>
        <h2 class="text-2xl font-display font-bold text-text-charcoal">{{ __('Library Control Panel') }}</h2>
        <p class="text-xs text-gray-500 font-semibold">{{ __('Configure lending limits, default durations, and active overdue penalty metrics globally.') }}</p>
    </div>

    <!-- Pristine Glassmorphic Card Container -->
    <div class="card p-8 bg-white/80 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.15)] rounded-3xl backdrop-blur-md">
        
        <form method="POST" action="{{ route('admin.settings.update') }}" x-data="{ submitted: false }" @submit="submitted = true">
            @csrf
            
            <div class="space-y-6">
                
                <!-- Maximum Checkout Count Rule -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center pb-6 border-b border-secondary-blush/30">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-text-charcoal mb-1">{{ __('Max Books Allowed') }}</label>
                        <p class="text-[11px] text-gray-400 font-semibold leading-relaxed">{{ __('The absolute maximum active checkouts a borrower can hold simultaneously.') }}</p>
                    </div>
                    <div class="md:col-span-2 relative">
                        <input 
                            type="number" 
                            name="max_books_allowed" 
                            value="{{ $maxBooksAllowed }}"
                            min="1" 
                            max="50" 
                            class="input-field py-3 px-4 text-sm font-bold" 
                            required
                        >
                        <div class="absolute right-4 top-3 text-[11px] text-primary-rose font-bold uppercase tracking-wider">
                            {{ __('Books') }}
                        </div>
                    </div>
                </div>

                <!-- Borrow Duration Limit Rule -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center pb-6 border-b border-secondary-blush/30">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-text-charcoal mb-1">{{ __('Standard Borrow Duration') }}</label>
                        <p class="text-[11px] text-gray-400 font-semibold leading-relaxed">{{ __('Default duration in days for every checkout reservation before being marked overdue.') }}</p>
                    </div>
                    <div class="md:col-span-2 relative">
                        <input 
                            type="number" 
                            name="default_borrow_duration" 
                            value="{{ $defaultBorrowDuration }}"
                            min="1" 
                            max="365" 
                            class="input-field py-3 px-4 text-sm font-bold" 
                            required
                        >
                        <div class="absolute right-4 top-3 text-[11px] text-primary-rose font-bold uppercase tracking-wider">
                            {{ __('Days') }}
                        </div>
                    </div>
                </div>

                <!-- Daily Overdue Penalty Accumulation Rate -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center pb-6">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-text-charcoal mb-1">{{ __('Daily Penalty Fee') }}</label>
                        <p class="text-[11px] text-gray-400 font-semibold leading-relaxed">{{ __('Accrued penalty amount (in IDR) calculated dynamically per overdue day.') }}</p>
                    </div>
                    <div class="md:col-span-2 relative">
                        <div class="absolute left-4 top-3 text-sm text-gray-400 font-bold">
                            Rp
                        </div>
                        <input 
                            type="number" 
                            name="daily_fine_rate" 
                            value="{{ $dailyFineRate }}"
                            min="0" 
                            class="input-field py-3 pl-10 pr-4 text-sm font-bold" 
                            required
                        >
                        <div class="absolute right-4 top-3 text-[11px] text-primary-rose font-bold uppercase tracking-wider">
                            / {{ __('Day') }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- Settle Form Buttons -->
            <div class="flex items-center justify-end gap-3 mt-8 border-t border-secondary-blush/30 pt-6">
                <button 
                    type="submit" 
                    :disabled="submitted" 
                    class="btn-primary py-3.5 px-8 text-xs inline-flex items-center gap-2 transform hover:-translate-y-0.5 active:translate-y-0 transition shadow-sm"
                >
                    <template x-if="submitted">
                        <svg class="animate-spin h-3.5 w-3.5 text-text-charcoal" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="submitted ? '{{ __('Updating Rules...') }}' : '{{ __('Save Changes') }}'"></span>
                </button>
            </div>

        </form>

    </div>

</div>
@endsection

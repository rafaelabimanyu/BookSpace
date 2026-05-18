@extends('layouts.bookspace')

@section('title', __('Fines & Penalty Management'))
@section('header_title', __('Fines Management'))

@section('content')
<div class="space-y-8 animate-fadeIn">
    
    <!-- Top Row Header -->
    <div>
        <h2 class="text-2xl font-display font-bold text-text-charcoal">{{ __('Global Penalty Ledger') }}</h2>
        <p class="text-xs text-gray-500 font-semibold">{{ __('Monitor library defaults, calculate daily late penalty ratios, and verify settles.') }}</p>
    </div>

    <!-- Pristine Glassmorphic Table -->
    <div class="card p-6 bg-white/80 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.15)] rounded-3xl backdrop-blur-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-xs uppercase tracking-wider">
                        <th class="py-4 px-4 font-display">#</th>
                        <th class="py-4 px-4 font-display">{{ __('Borrower') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Book Title') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Return Deadline') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Days Late') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Calculated Penalty') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Status') }}</th>
                        <th class="py-4 px-4 font-display text-right">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-blush/30 font-medium text-sm">
                    @forelse($borrowings as $index => $b)
                        <tr class="hover:bg-secondary-blush/10 transition">
                            <td class="py-4 px-4 text-gray-500 text-xs">{{ $index + 1 }}</td>
                            <td class="py-4 px-4 font-bold text-text-charcoal font-body">
                                <div>{{ $b->user->name }}</div>
                                <div class="text-[10px] text-gray-400 font-semibold mt-0.5">{{ $b->user->email }}</div>
                            </td>
                            <td class="py-4 px-4 text-gray-600 font-semibold font-body">{{ $b->book->title }}</td>
                            <td class="py-4 px-4 text-gray-500 font-semibold">
                                {{ date('d M Y', strtotime($b->return_date)) }}
                            </td>
                            <td class="py-4 px-4">
                                @if($b->days_late > 0)
                                    <span class="text-rose-500 font-extrabold">{{ $b->days_late }} {{ __('Days') }}</span>
                                @else
                                    <span class="text-emerald-500 font-bold">0 {{ __('Days') }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-bold text-text-charcoal font-body">
                                Rp {{ number_format($b->calculated_fine, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4">
                                @if($b->fine_status === 'paid')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        {{ __('Paid') }}
                                    </span>
                                @else
                                    <span class="relative flex h-2 w-2 mb-1.5 inline-block mr-1">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                    </span>
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 border border-amber-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('Unpaid') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                @if($b->fine_status !== 'paid' && $b->calculated_fine > 0)
                                    <form method="POST" action="{{ route('fines.verify', $b->id) }}" x-data="{ submitted: false }" @submit="submitted = true" class="inline">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            :disabled="submitted"
                                            class="btn-primary py-2 px-4 text-[10px] inline-flex items-center gap-1.5 shadow-xs"
                                        >
                                            <template x-if="submitted">
                                                <svg class="animate-spin h-3 w-3 text-text-charcoal" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </template>
                                            <span>{{ __('Verify Payment') }}</span>
                                        </button>
                                    </form>
                                @else
                                    <button class="px-3 py-2 bg-gray-50 border border-gray-100 rounded-xl text-[10px] font-bold text-gray-400 cursor-not-allowed" disabled>
                                        {{ __('Settled') }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400 font-semibold font-body">
                                {{ __('No overdue items or penalty fines recorded in the ledger.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

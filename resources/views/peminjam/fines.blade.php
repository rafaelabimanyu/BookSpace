@extends('layouts.bookspace')

@section('title', __('Fines & Penalties'))

@section('header_title', __('Fines & Penalties'))

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <h2 class="text-2xl font-display font-bold text-text-charcoal mb-2">{{ __('My Penalty Ledger') }}</h2>

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-secondary-blush/40 border-b border-secondary-blush/80">
                            <th class="py-4 px-6 text-xs uppercase font-bold text-text-charcoal/60">{{ __('Book Title') }}</th>
                            <th class="py-4 px-6 text-xs uppercase font-bold text-text-charcoal/60">{{ __('Borrow Date') }}</th>
                            <th class="py-4 px-6 text-xs uppercase font-bold text-text-charcoal/60">{{ __('Return Deadline') }}</th>
                            <th class="py-4 px-6 text-xs uppercase font-bold text-text-charcoal/60 text-center">{{ __('Days Late') }}</th>
                            <th class="py-4 px-6 text-xs uppercase font-bold text-text-charcoal/60 text-right">{{ __('Accumulated Fine') }}</th>
                            <th class="py-4 px-6 text-xs uppercase font-bold text-text-charcoal/60 text-center">{{ __('Status') }}</th>
                            <th class="py-4 px-6 text-xs uppercase font-bold text-text-charcoal/60 text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-blush/30">
                        @forelse($borrowings as $borrowing)
                            @if($borrowing->calculated_fine > 0 || $borrowing->fine_amount > 0 || $borrowing->fine_status === 'paid')
                                <tr class="hover:bg-secondary-blush/5 transition">
                                    <!-- Book Title -->
                                    <td class="py-4 px-6">
                                        <span class="block font-bold text-sm text-text-charcoal">{{ $borrowing->book->title }}</span>
                                        <span class="block text-[10px] text-text-charcoal/50 font-medium mt-0.5">ISBN: {{ $borrowing->book->ISBN }}</span>
                                    </td>
                                    
                                    <!-- Borrow Date -->
                                    <td class="py-4 px-6 text-xs font-semibold text-text-charcoal/80">
                                        {{ \Carbon\Carbon::parse($borrowing->borrow_date)->translatedFormat('d M Y') }}
                                    </td>

                                    <!-- Return Deadline -->
                                    <td class="py-4 px-6 text-xs font-semibold text-text-charcoal/80">
                                        {{ \Carbon\Carbon::parse($borrowing->return_date)->translatedFormat('d M Y') }}
                                    </td>

                                    <!-- Days Late -->
                                    <td class="py-4 px-6 text-center text-xs font-bold {{ $borrowing->days_late > 0 && $borrowing->fine_status !== 'paid' ? 'text-rose-500 animate-pulse' : 'text-text-charcoal/60' }}">
                                        {{ $borrowing->days_late }} {{ __('Days') }}
                                    </td>

                                    <!-- Total Accumulated Fine -->
                                    <td class="py-4 px-6 text-right text-xs font-bold text-text-charcoal/80">
                                        Rp {{ number_format($borrowing->calculated_fine, 0, ',', '.') }}
                                    </td>

                                    <!-- Fine Status Tag -->
                                    <td class="py-4 px-6 text-center">
                                        @if($borrowing->fine_status === 'paid')
                                            <span class="inline-flex px-3 py-1 bg-emerald-100 text-emerald-600 rounded-2xl text-[10px] font-extrabold shadow-sm uppercase tracking-wide">
                                                {{ __('Paid') }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 bg-rose-100 text-rose-500 rounded-2xl text-[10px] font-extrabold shadow-sm uppercase tracking-wide animate-pulse">
                                                {{ __('Unpaid') }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions (Simulation Button) -->
                                    <td class="py-4 px-6 text-center" x-data="{ paying: false }">
                                        @if($borrowing->fine_status !== 'paid' && $borrowing->calculated_fine > 0)
                                            <form action="{{ route('peminjam.fines.pay', $borrowing->id) }}" method="POST" @submit="paying = true">
                                                @csrf
                                                <button type="submit" class="btn-primary py-1.5 px-4 text-[10px] font-extrabold flex items-center justify-center gap-1 mx-auto" :disabled="paying">
                                                    <svg x-show="paying" class="animate-spin h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <span x-text="paying ? '{{ __('Processing...') }}' : '{{ __('Pay Fine') }}'"></span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs font-semibold text-text-charcoal/40">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-400 font-medium">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="p-4 bg-secondary-blush/60 rounded-full text-primary-rose">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-text-charcoal/70">{{ __('Excellent! No outstanding fines at the moment.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

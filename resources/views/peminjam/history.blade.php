@extends('layouts.bookspace')

@section('title', __('My Borrowing History'))

@section('header_title', __('My Borrowing History'))

@section('content')
    <div class="card p-6">
        <h2 class="text-2xl font-display font-bold text-text-charcoal mb-6">{{ __('History') }}</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-sm">
                        <th class="py-4 px-4 font-display">#</th>
                        <th class="py-4 px-4 font-display">{{ __('Book Title') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Borrow Date') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Return Deadline') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-blush/40 font-medium">
                    @forelse($borrowings as $index => $borrowing)
                        <tr class="hover:bg-secondary-blush/10 transition">
                            <td class="py-4 px-4 text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-4">
                                <div class="text-text-charcoal font-bold text-base">{{ $borrowing->book->title }}</div>
                                <div class="text-gray-400 text-xs mt-0.5 font-semibold">ISBN: {{ $borrowing->book->ISBN }}</div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">
                                {{ date('d M Y', strtotime($borrowing->borrow_date)) }}
                            </td>
                            <td class="py-4 px-4 text-gray-600">
                                {{ date('d M Y', strtotime($borrowing->return_date)) }}
                            </td>
                            <td class="py-4 px-4">
                                @if($borrowing->status === 'borrowed')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-bold rounded-lg border border-amber-100 uppercase tracking-wider">
                                        {{ __('Borrowed') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-lg border border-emerald-100 uppercase tracking-wider">
                                        {{ __('Returned') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400 font-medium">
                                {{ __('No borrowing history found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('layouts.bookspace')

@section('title', __('Library Circulation'))

@section('header_title', __('Library Circulation'))

@section('content')
    <div class="card p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <h2 class="text-2xl font-display font-bold text-text-charcoal">{{ __('Borrowings') }}</h2>
            <a href="{{ route('borrowings.create') }}" class="btn-primary py-3 px-6 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Record Borrowing') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-sm">
                        <th class="py-4 px-4 font-display">#</th>
                        <th class="py-4 px-4 font-display">{{ __('Borrower') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Book Title') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Borrow Date') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Return Date') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Status') }}</th>
                        <th class="py-4 px-4 font-display text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-blush/40 font-medium">
                    @forelse($borrowings as $index => $borrowing)
                        <tr class="hover:bg-secondary-blush/10 transition">
                            <td class="py-4 px-4 text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-4">
                                <div class="text-text-charcoal font-bold">{{ $borrowing->user->name }}</div>
                                <div class="text-gray-400 text-xs mt-0.5 font-semibold">{{ $borrowing->user->email }}</div>
                            </td>
                            <td class="py-4 px-4 text-text-charcoal font-semibold">{{ $borrowing->book->title }}</td>
                            <td class="py-4 px-4 text-gray-600">{{ date('d M Y', strtotime($borrowing->borrow_date)) }}</td>
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
                            <td class="py-4 px-4 text-right">
                                @if($borrowing->status === 'borrowed')
                                    <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure this book is being returned?') }}')" class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-600 rounded-2xl text-xs font-bold hover:bg-emerald-600 hover:text-white transition shadow-sm border border-emerald-100">
                                            {{ __('Return Book') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs font-bold font-display italic mr-2">{{ __('Returned') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400 font-medium">
                                {{ __('No borrowings recorded.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

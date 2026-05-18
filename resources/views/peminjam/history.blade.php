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
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                                    @if($borrowing->status === 'borrowed')
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-bold rounded-lg border border-amber-100 uppercase tracking-wider">
                                            {{ __('Borrowed') }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-lg border border-emerald-100 uppercase tracking-wider">
                                            {{ __('Returned') }}
                                        </span>
                                        <button 
                                            @click="$dispatch('open-review-modal', { id: {{ $borrowing->book->id }}, title: '{{ addslashes($borrowing->book->title) }}' })"
                                            class="inline-flex items-center px-3 py-1.5 bg-secondary-blush text-primary-rose rounded-xl text-[10px] font-bold hover:bg-primary-rose hover:text-white transition shadow-sm border border-primary-rose/20 uppercase tracking-wider"
                                        >
                                            {{ __('Beri Ulasan') }}
                                        </button>
                                    @endif
                                </div>
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

    <!-- Write Review Modal -->
    <div 
        x-data="{ 
            open: false, 
            bookId: '', 
            bookTitle: '',
            rating: 5,
            hoverRating: 0,
            comment: '',
            loading: false,
            openModal(id, title) {
                this.bookId = id;
                this.bookTitle = title;
                this.rating = 5;
                this.comment = '';
                this.open = true;
            }
        }"
        @open-review-modal.window="openModal($event.detail.id, $event.detail.title)"
        x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-text-charcoal/40 backdrop-blur-sm"
        style="display: none;"
    >
        <!-- Modal container -->
        <div 
            @click.away="if (!loading) open = false" 
            class="bg-white border border-secondary-blush/60 rounded-3xl p-6 shadow-2xl w-full max-w-md transform transition-all"
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <!-- Modal Header -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-display font-bold text-text-charcoal">{{ __('Write Review') }}</h3>
                    <p class="text-gray-500 font-medium text-xs mt-1" x-text="bookTitle"></p>
                </div>
                <button @click="open = false" :disabled="loading" class="text-gray-400 hover:text-text-charcoal transition rounded-lg p-1 hover:bg-secondary-blush/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('peminjam.review.store') }}" method="POST" @submit="loading = true">
                @csrf
                <input type="hidden" name="book_id" :value="bookId">
                <input type="hidden" name="rating" :value="rating">

                <!-- Star Rating Selector -->
                <div class="mb-4 text-center">
                    <label class="block text-gray-700 text-xs font-bold uppercase tracking-wider mb-2">{{ __('Rating') }}</label>
                    <div class="flex justify-center gap-2">
                        <template x-for="i in [1,2,3,4,5]">
                            <button 
                                type="button" 
                                @click="rating = i"
                                @mouseenter="hoverRating = i"
                                @mouseleave="hoverRating = 0"
                                class="text-3xl focus:outline-none transition duration-150 transform hover:scale-110"
                                :class="(hoverRating ? i <= hoverRating : i <= rating) ? 'text-amber-400' : 'text-gray-200'"
                            >
                                ★
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Comment Input -->
                <div class="mb-6">
                    <label for="comment" class="block text-gray-700 text-xs font-bold uppercase tracking-wider mb-2">{{ __('Comment') }}</label>
                    <textarea 
                        name="comment" 
                        id="comment" 
                        rows="4" 
                        required 
                        placeholder="{{ __('Write your honest review here...') }}"
                        class="input-field p-4 bg-bg-cream/40 border-secondary-blush/80 focus:bg-white transition text-sm rounded-2xl w-full"
                        x-model="comment"
                    ></textarea>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button type="button" @click="open = false" :disabled="loading" class="btn-secondary py-2.5 px-4 text-xs font-bold flex-1 text-center">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" :disabled="loading" class="btn-primary py-2.5 px-4 text-xs font-bold flex-1 flex items-center justify-center gap-2" :class="loading ? 'opacity-75 cursor-not-allowed bg-primary-rose/80' : ''">
                        <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? '{{ __('Submitting...') }}' : '{{ __('Submit') }}'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.bookspace')

@section('title', __('Dashboard'))

@section('header_title')
    {{ __('Hello') }}, {{ auth()->user()->name }}
@endsection

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-display font-bold text-text-charcoal mb-2">{{ __('Welcome back to BookSpace') }}!</h2>
        <p class="text-gray-500 font-medium">{{ __('Here is an overview of your library activity today.') }}</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6 bg-gradient-to-br from-white to-secondary-blush border-none">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Total Books') }}</h3>
                <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-display font-bold text-primary-rose">245</p>
        </div>

        <div class="card p-6 bg-gradient-to-br from-white to-pink-50 border-none">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Active Borrowings') }}</h3>
                <div class="p-3 bg-white rounded-2xl shadow-sm text-primary-rose">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-display font-bold text-primary-rose">12</p>
        </div>

        <div class="card p-6 bg-gradient-to-br from-white to-rose-50 border-none">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-text-charcoal">{{ __('Overdue Books') }}</h3>
                <div class="p-3 bg-white rounded-2xl shadow-sm text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-display font-bold text-red-500">2</p>
        </div>
    </div>

    <!-- Recent Activity Placeholder -->
    <div class="card p-6">
        <h3 class="text-xl font-display font-bold text-text-charcoal mb-4">{{ __('Recent Activity') }}</h3>
        <div class="text-center py-10 text-gray-400 font-medium">
            {{ __('No recent activity to display.') }}
        </div>
    </div>
@endsection

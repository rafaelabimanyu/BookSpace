@extends('layouts.bookspace')

@section('title', __('Reports'))

@section('header_title', __('Library Reports'))

@section('content')
    <!-- Print Specific Report Title (Hidden in browser, visible on print) -->
    <div class="hidden print:block text-center mb-8">
        <h1 class="text-3xl font-display font-bold text-text-charcoal mb-2">BookSpace</h1>
        <h2 class="text-xl font-display font-semibold text-gray-600">{{ __('Library Circulation Report') }}</h2>
        <p class="text-xs text-gray-400 mt-2">{{ __('Generated on') }}: {{ date('d M Y H:i') }}</p>
        <hr class="mt-4 border-gray-300">
    </div>

    <!-- Web Filter Card (Hidden in Print) -->
    <div class="card p-6 mb-8 bg-white border border-secondary-blush/60 shadow-sm print:hidden">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="text-xl font-display font-bold text-text-charcoal">{{ __('Report Filters') }}</h2>
                <p class="text-xs text-gray-500 font-medium mt-1">{{ __('Select filters below to generate custom circulation timeline reports.') }}</p>
            </div>
            
            <button onclick="window.print()" class="btn-primary py-3 px-6 text-sm flex items-center gap-2 transform hover:scale-105 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                {{ __('Print Report') }}
            </button>
        </div>

        <form action="{{ route('admin.reports') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Month filter -->
            <div>
                <label for="month" class="block font-semibold text-xs text-text-charcoal mb-2">{{ __('Month') }}</label>
                <select name="month" id="month" class="input-field py-2.5 px-4 text-sm bg-bg-cream/40 border-secondary-blush/80">
                    <option value="">{{ __('All Months') }}</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <label for="year" class="block font-semibold text-xs text-text-charcoal mb-2">{{ __('Year') }}</label>
                <select name="year" id="year" class="input-field py-2.5 px-4 text-sm bg-bg-cream/40 border-secondary-blush/80">
                    <option value="">{{ __('All Years') }}</option>
                    @foreach($yearsList as $yr)
                        <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>
                            {{ $yr }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category_id" class="block font-semibold text-xs text-text-charcoal mb-2">{{ __('Category') }}</label>
                <select name="category_id" id="category_id" class="input-field py-2.5 px-4 text-sm bg-bg-cream/40 border-secondary-blush/80">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter trigger buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-primary py-2.5 px-6 text-sm flex-1">
                    {{ __('Filter') }}
                </button>
                @if($month || $year || $categoryId)
                    <a href="{{ route('admin.reports') }}" class="btn-secondary py-2.5 px-6 text-sm text-center">
                        {{ __('Reset') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Overall Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stock count -->
        <div class="card p-6 bg-gradient-to-br from-white to-secondary-blush border border-secondary-blush/40 shadow-xs">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ __('Total Inventory Valuation') }}</h3>
            <p class="text-3xl font-display font-bold text-primary-rose">{{ $totalBooksCount }}</p>
            <p class="text-xs text-gray-400 font-semibold mt-1">{{ __('Across') }} {{ $totalBooksTitles }} {{ __('unique titles') }}</p>
        </div>

        <!-- Active Readers -->
        <div class="card p-6 bg-gradient-to-br from-white to-pink-50 border border-secondary-blush/40 shadow-xs">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ __('Active Readers') }}</h3>
            <p class="text-3xl font-display font-bold text-primary-rose">{{ $activeReadersCount }}</p>
            <p class="text-xs text-gray-400 font-semibold mt-1">{{ __('Borrowers currently holding books') }}</p>
        </div>

        <!-- Fulfillment rates -->
        <div class="card p-6 bg-gradient-to-br from-white to-rose-50 border border-secondary-blush/40 shadow-xs">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ __('Fulfillment Rate') }}</h3>
            <p class="text-3xl font-display font-bold text-primary-rose">{{ $fulfillmentRate }}%</p>
            <p class="text-xs text-gray-400 font-semibold mt-1">{{ __('Of total historical logs returned') }}</p>
        </div>
    </div>

    <!-- Printed Circulation Ledger -->
    <div class="card p-6 bg-white border border-secondary-blush/40 shadow-xs">
        <h3 class="text-xl font-display font-bold text-text-charcoal mb-6">{{ __('Circulation Ledger') }}</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse print:text-xs">
                <thead>
                    <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-xs uppercase">
                        <th class="py-3 px-4 font-display">#</th>
                        <th class="py-3 px-4 font-display">{{ __('Borrower') }}</th>
                        <th class="py-3 px-4 font-display">{{ __('Book Title') }}</th>
                        <th class="py-3 px-4 font-display">{{ __('Category') }}</th>
                        <th class="py-3 px-4 font-display">{{ __('Borrow Date') }}</th>
                        <th class="py-3 px-4 font-display">{{ __('Return Deadline') }}</th>
                        <th class="py-3 px-4 font-display">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-blush/20 font-medium text-sm">
                    @forelse($borrowings as $index => $item)
                        <tr class="hover:bg-secondary-blush/10 transition">
                            <td class="py-3 px-4 text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                <div class="text-text-charcoal font-bold">{{ $item->user->name }}</div>
                                <div class="text-gray-400 text-xs print:hidden">{{ $item->user->email }}</div>
                            </td>
                            <td class="py-3 px-4 text-gray-700 font-semibold leading-tight">{{ $item->book->title }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 bg-secondary-blush text-primary-rose text-[10px] font-bold rounded-lg border border-secondary-blush/50 uppercase">
                                    {{ $item->book->category->name }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-500">{{ date('d M Y', strtotime($item->borrow_date)) }}</td>
                            <td class="py-3 px-4 text-gray-500">{{ date('d M Y', strtotime($item->return_date)) }}</td>
                            <td class="py-3 px-4">
                                @if($item->status === 'borrowed')
                                    <span class="px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-100 rounded text-xs font-bold uppercase tracking-wider">{{ __('Borrowed') }}</span>
                                @else
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded text-xs font-bold uppercase tracking-wider">{{ __('Returned') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400">
                                {{ __('No matching circulation records found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Print styling overrides -->
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            aside, header, .print\:hidden, form {
                display: none !important;
            }
            .flex-1 {
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
                overflow: visible !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
                margin-bottom: 2rem !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                border-bottom: 1px solid #ddd !important;
                padding: 8px !important;
            }
        }
    </style>
@endsection

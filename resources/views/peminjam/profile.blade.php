@extends('layouts.bookspace')

@section('title', __('My Profile'))

@section('header_title', __('My Profile'))

@section('content')
    <!-- Print Stylesheet Isolation -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-member-card, #print-member-card * {
                visibility: visible;
            }
            #print-member-card {
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%) scale(1.3);
                border: none !important;
                box-shadow: none !important;
                background: linear-gradient(135deg, #FCEAEA 0%, #F3C5C5 100%) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-8 items-start">
        <!-- Left Side Profile Info Form -->
        <div class="w-full lg:w-1/2 card p-8 space-y-6">
            <h2 class="text-xl font-display font-bold text-text-charcoal">{{ __('Update Profile Information') }}</h2>

            <form action="{{ route('peminjam.profile.update') }}" method="POST" enctype="multipart/form-data" x-data="{ submitted: false }" @submit="submitted = true">
                @csrf
                
                <!-- Current Profile Picture Preview -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="relative w-20 h-20 rounded-full overflow-hidden border-4 border-white shadow-sm bg-secondary-blush flex items-center justify-center">
                        @if($user->profile_picture)
                            <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-primary-rose font-display font-bold text-2xl uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <label for="profile_picture" class="block font-semibold text-xs text-text-charcoal mb-1">{{ __('Upload New Photo') }}</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="text-xs text-text-charcoal/60 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-secondary-blush file:text-primary-rose hover:file:bg-primary-rose hover:file:text-white file:transition-all file:cursor-pointer">
                        @error('profile_picture')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Name Input -->
                <div class="mb-5">
                    <label for="name" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Full Name') }}</label>
                    <input type="text" name="name" id="name" class="input-field py-3 px-4 @error('name') border-red-400 focus:ring-red-400 @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email" class="input-field py-3 px-4 @error('email') border-red-400 focus:ring-red-400 @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button with Double-Submit Shield -->
                <button type="submit" class="btn-primary w-full py-3 text-sm flex items-center justify-center gap-2" :disabled="submitted">
                    <svg x-show="submitted" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="submitted ? '{{ __('Processing...') }}' : '{{ __('Save Changes') }}'"></span>
                </button>
            </form>
        </div>

        <!-- Right Side Digital E-Card Widget -->
        <div class="w-full lg:w-1/2 flex flex-col items-center gap-6">
            <div class="w-full text-left">
                <h2 class="text-xl font-display font-bold text-text-charcoal">{{ __('Library Member E-Card') }}</h2>
                <p class="text-xs text-text-charcoal/50 mt-1">{{ __('Carry your virtual member identity to access library checkout stations.') }}</p>
            </div>

            <!-- E-Card Container -->
            <div id="print-member-card" class="relative w-full max-w-[420px] aspect-[1.58/1] rounded-3xl p-6 overflow-hidden shadow-lg border border-white/40 flex flex-col justify-between bg-gradient-to-br from-secondary-blush to-primary-rose">
                <!-- Decorative background elements -->
                <div class="absolute -right-16 -top-16 w-44 h-44 rounded-full bg-white/20 blur-xl"></div>
                <div class="absolute -left-12 -bottom-12 w-36 h-36 rounded-full bg-white/25 blur-lg"></div>

                <!-- Header Logo & Branding -->
                <div class="flex items-center justify-between z-10">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="font-display font-extrabold text-white text-lg tracking-wide">BookSpace</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-white uppercase tracking-wider bg-white/25 px-3 py-1 rounded-xl shadow-sm">
                        {{ __('Member') }}
                    </span>
                </div>

                <!-- Center Name & Photo -->
                <div class="flex items-center gap-4 z-10 mt-2">
                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-white bg-white/30 flex items-center justify-center flex-shrink-0 shadow-sm">
                        @if($user->profile_picture)
                            <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-white font-display font-bold text-lg">
                                {{ substr($user->name, 0, 1) }}
                            </span>
                        @endif
                    </div>
                    <div class="space-y-0.5">
                        <span class="block font-display font-bold text-white text-base tracking-tight leading-tight">{{ $user->name }}</span>
                        <span class="block text-[11px] font-bold text-white/80 uppercase tracking-wider">ID: BSP-{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                <!-- Footer Barcode & Register date -->
                <div class="flex items-end justify-between z-10 border-t border-white/20 pt-4 mt-2">
                    <div class="text-[10px] text-white/80 font-bold uppercase space-y-0.5">
                        <span>{{ __('Register Date') }}</span>
                        <span class="block text-white font-extrabold">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                    </div>

                    <!-- Stylized Mock Barcode -->
                    <div class="flex flex-col items-center gap-1">
                        <div class="flex items-center gap-[1.5px] bg-white/95 px-3 py-1.5 rounded-lg justify-center shadow-sm">
                            <div class="w-[3px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[1.5px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[4px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[1px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[3px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[6px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[2px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[3px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[5px] h-5 bg-text-charcoal rounded-sm"></div>
                            <div class="w-[1px] h-5 bg-text-charcoal rounded-sm"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Card Trigger Button -->
            <button onclick="window.print()" class="btn-primary py-3 px-6 text-sm flex items-center justify-center gap-2 w-full max-w-[420px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                {{ __('Print Member Card') }}
            </button>
        </div>
    </div>
@endsection

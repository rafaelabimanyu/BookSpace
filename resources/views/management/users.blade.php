@extends('layouts.bookspace')

@section('title', __('User Management'))
@section('header_title', __('User Management'))

@section('content')
<div x-data="{ openAddModal: false, openEditModal: false, editUser: { id: '', name: '', email: '', role: '' } }" class="space-y-8">
    
    <!-- Top Action Row -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-display font-bold text-text-charcoal">{{ __('Library Accounts') }}</h2>
            <p class="text-xs text-gray-500 font-semibold">{{ __('Manage profiles, role levels, and authorization scopes.') }}</p>
        </div>
        <button @click="openAddModal = true" class="btn-primary py-3 px-6 text-xs inline-flex items-center gap-2 shadow-sm transform hover:-translate-y-0.5 active:translate-y-0 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Add Account') }}
        </button>
    </div>

    <!-- pristine data table -->
    <div class="card p-6 bg-white/80 border border-primary-rose/30 shadow-[0_8px_30px_rgba(243,197,197,0.15)] rounded-3xl backdrop-blur-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-xs uppercase tracking-wider">
                        <th class="py-4 px-4 font-display">#</th>
                        <th class="py-4 px-4 font-display">{{ __('Name') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Email Address') }}</th>
                        <th class="py-4 px-4 font-display">{{ __('Role Badge') }}</th>
                        <th class="py-4 px-4 font-display text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-blush/30 font-medium text-sm">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-secondary-blush/10 transition">
                            <td class="py-4 px-4 text-gray-500 text-xs">{{ $index + 1 }}</td>
                            <td class="py-4 px-4 text-text-charcoal font-bold font-body">{{ $u->name }}</td>
                            <td class="py-4 px-4 text-gray-600 font-semibold font-body">{{ $u->email }}</td>
                            <td class="py-4 px-4">
                                @if($u->role === 'admin')
                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 border border-rose-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('Admin') }}
                                    </span>
                                @elseif($u->role === 'petugas')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 border border-amber-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('Petugas') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('Peminjam') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Trigger -->
                                    <button 
                                        @click="editUser = { id: '{{ $u->id }}', name: '{{ addslashes($u->name) }}', email: '{{ addslashes($u->email) }}', role: '{{ $u->role }}' }; openEditModal = true" 
                                        class="p-2 text-primary-rose hover:bg-secondary-blush rounded-xl transition duration-150"
                                        title="{{ __('Edit Profile') }}"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <!-- Delete Trigger -->
                                    @if($u->id !== auth()->user()->id)
                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition duration-150"
                                                title="{{ __('Delete Profile') }}"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="p-2 text-gray-300 cursor-not-allowed" title="{{ __('Self-destruction blocked') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0-8V7m0 0v2m0-2h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"></path></svg>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400 font-semibold font-body">
                                {{ __('No user accounts registered.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= MODALS ================= -->
    
    <!-- Add Account Modal -->
    <div x-show="openAddModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-text-charcoal/40 backdrop-blur-xs animate-fadeIn" x-cloak>
        <div @click.away="openAddModal = false" class="card w-full max-w-md p-8 bg-white border border-primary-rose/40 shadow-2xl relative"
             x-show="openAddModal"
             x-transition:enter="transition-premium transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition-premium transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <button @click="openAddModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-text-charcoal transition p-1 hover:bg-secondary-blush rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <h3 class="text-2xl font-display font-bold text-text-charcoal mb-6 border-b border-secondary-blush/30 pb-3">{{ __('Add Account') }}</h3>

            <form method="POST" action="{{ route('admin.users.store') }}" x-data="{ submitted: false }" @submit="submitted = true">
                @csrf
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Full Name') }}</label>
                        <input type="text" name="name" class="input-field py-2.5 px-4 text-sm" placeholder="{{ __('e.g. John Doe') }}" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
                        <input type="email" name="email" class="input-field py-2.5 px-4 text-sm" placeholder="{{ __('e.g. john@email.com') }}" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Password') }}</label>
                        <input type="password" name="password" class="input-field py-2.5 px-4 text-sm" placeholder="••••••••" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Role Assignment') }}</label>
                        <select name="role" class="input-field py-3 px-4 text-sm" required>
                            <option value="">{{ __('Select Role') }}</option>
                            @foreach($roles as $r)
                                <option value="{{ $r }}">{{ __(ucfirst($r)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-secondary-blush/30 pt-4">
                    <button type="button" @click="openAddModal = false" class="px-6 py-3 bg-secondary-blush border border-primary-rose rounded-2xl font-display font-semibold text-primary-rose uppercase tracking-widest hover:bg-rose-50 text-[10px] transition duration-150">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" :disabled="submitted" class="btn-primary py-3 px-6 text-[10px] inline-flex items-center gap-2">
                        <template x-if="submitted">
                            <svg class="animate-spin h-3.5 w-3.5 text-text-charcoal" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="submitted ? '{{ __('Processing...') }}' : '{{ __('Save') }}'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Account Modal -->
    <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-text-charcoal/40 backdrop-blur-xs animate-fadeIn" x-cloak>
        <div @click.away="openEditModal = false" class="card w-full max-w-md p-8 bg-white border border-primary-rose/40 shadow-2xl relative"
             x-show="openEditModal"
             x-transition:enter="transition-premium transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition-premium transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <button @click="openEditModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-text-charcoal transition p-1 hover:bg-secondary-blush rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <h3 class="text-2xl font-display font-bold text-text-charcoal mb-6 border-b border-secondary-blush/30 pb-3">{{ __('Edit Profile') }}</h3>

            <form method="POST" :action="`{{ url('admin/users') }}/${editUser.id}`" x-data="{ submitted: false }" @submit="submitted = true">
                @csrf
                @method('PATCH')
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Full Name') }}</label>
                        <input type="text" name="name" x-model="editUser.name" class="input-field py-2.5 px-4 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
                        <input type="email" name="email" x-model="editUser.email" class="input-field py-2.5 px-4 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Password') }} <span class="text-gray-400">({{ __('Leave blank to keep current') }})</span></label>
                        <input type="password" name="password" class="input-field py-2.5 px-4 text-sm" placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Role Assignment') }}</label>
                        <select name="role" x-model="editUser.role" class="input-field py-3 px-4 text-sm" required>
                            @foreach($roles as $r)
                                <option value="{{ $r }}">{{ __(ucfirst($r)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-secondary-blush/30 pt-4">
                    <button type="button" @click="openEditModal = false" class="px-6 py-3 bg-secondary-blush border border-primary-rose rounded-2xl font-display font-semibold text-primary-rose uppercase tracking-widest hover:bg-rose-50 text-[10px] transition duration-150">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" :disabled="submitted" class="btn-primary py-3 px-6 text-[10px] inline-flex items-center gap-2">
                        <template x-if="submitted">
                            <svg class="animate-spin h-3.5 w-3.5 text-text-charcoal" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="submitted ? '{{ __('Processing...') }}' : '{{ __('Save') }}'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

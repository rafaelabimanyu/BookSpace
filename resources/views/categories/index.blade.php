@extends('layouts.bookspace')

@section('title', __('Category Management'))

@section('header_title', __('Category Management'))

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Categories List Card -->
        <div class="lg:col-span-2 card p-6">
            <h2 class="text-2xl font-display font-bold mb-6 text-text-charcoal">{{ __('Categories') }}</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-secondary-blush text-gray-400 font-semibold text-sm">
                            <th class="py-4 px-4 font-display">#</th>
                            <th class="py-4 px-4 font-display">{{ __('Category Name') }}</th>
                            <th class="py-4 px-4 font-display">{{ __('Books') }}</th>
                            <th class="py-4 px-4 font-display text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-blush/40 font-medium">
                        @forelse($categories as $index => $category)
                            <tr class="hover:bg-secondary-blush/10 transition">
                                <td class="py-4 px-4 text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 text-text-charcoal font-semibold">{{ $category->name }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 bg-secondary-blush text-primary-rose text-xs font-bold rounded-full">
                                        {{ $category->books_count }} {{ __('Books') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right space-x-2">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-1.5 bg-secondary-blush text-primary-rose rounded-xl text-xs font-bold hover:bg-primary-rose hover:text-white transition shadow-sm">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}')" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold hover:bg-rose-600 hover:text-white transition shadow-sm">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400 font-medium">
                                    {{ __('No categories found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Category Form Card -->
        <div class="card p-6 bg-white/80 border border-secondary-blush shadow-md self-start">
            <h2 class="text-2xl font-display font-bold mb-6 text-text-charcoal">{{ __('Add Category') }}</h2>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="name" class="block font-semibold text-sm text-text-charcoal mb-2">{{ __('Category Name') }}</label>
                    <input type="text" name="name" id="name" class="input-field py-3 px-4 @error('name') border-red-400 focus:ring-red-400 @enderror" value="{{ old('name') }}" placeholder="{{ __('Enter category name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="submit" class="btn-primary py-3 px-6 text-sm">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

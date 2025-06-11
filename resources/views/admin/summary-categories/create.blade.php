@extends('layouts.admin')

@section('title', 'Create Summary Category')
@section('page-title', 'Create New Summary Category')

@section('content')
<div class="max-w-4xl">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Create New Summary Category</h2>
        <a href="{{ route('admin.summary-categories.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Categories</span>
        </a>
    </div>

    <!-- Form -->
    <div class="admin-card rounded-lg p-6">
        <form action="{{ route('admin.summary-categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- English Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Name (English) *</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Arabic Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Name (Arabic) *</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar') }}" 
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           dir="rtl" required>
                    @error('name_ar')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" 
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Leave empty to auto-generate">
                    <p class="text-gray-500 text-xs mt-1">Leave empty to auto-generate from name</p>
                    @error('slug')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Color Theme *</label>
                    <select name="color" 
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required>
                        @foreach($colors as $color)
                        <option value="{{ $color }}" {{ old('color', 'blue') === $color ? 'selected' : '' }}>
                            {{ ucfirst($color) }}
                        </option>
                        @endforeach
                    </select>
                    @error('color')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- English Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description (English)</label>
                    <textarea name="description" rows="4" 
                              class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                              placeholder="Brief description of this category">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Arabic Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description (Arabic)</label>
                    <textarea name="description_ar" rows="4" 
                              class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                              dir="rtl" placeholder="وصف مختصر لهذه الفئة">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Icon -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">SVG Icon</label>
                <textarea name="icon" rows="3" 
                          class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm" 
                          placeholder='<path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>'>{{ old('icon') }}</textarea>
                <p class="text-gray-500 text-xs mt-1">SVG path element only (without &lt;svg&gt; wrapper)</p>
                @error('icon')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Sort Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order') }}" 
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           min="0" placeholder="0">
                    <p class="text-gray-500 text-xs mt-1">Lower numbers appear first. Leave empty for auto-assignment.</p>
                    @error('sort_order')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <div class="flex items-center space-x-3 mt-2">
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', '1') === '1' ? 'checked' : '' }} 
                                   class="text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500 focus:ring-2">
                            <span class="ml-2 text-gray-300">Active</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="0" {{ old('is_active') === '0' ? 'checked' : '' }} 
                                   class="text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500 focus:ring-2">
                            <span class="ml-2 text-gray-300">Inactive</span>
                        </label>
                    </div>
                    @error('is_active')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-700">
                <a href="{{ route('admin.summary-categories.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors duration-300">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-300">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
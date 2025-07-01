@extends('layouts.admin')

@section('title', 'Add Category')
@section('page-title', 'Add New Category')

@section('content')
<div class="max-w-2xl">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
    </div>

    <!-- Form -->
    <div class="admin-card rounded-lg p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
            @csrf

            <h2 class="text-xl font-semibold text-white mb-6">Basic Information</h2>
            
            <!-- Parent Category (Optional) -->
            <div class="mb-6">
                <label for="parent_id" class="block text-sm font-medium text-gray-300 mb-2">
                    Category Type <span class="text-red-400">*</span>
                </label>
                
                <!-- Radio buttons for clarity -->
                <div class="space-y-3 mb-4">
                    <label class="flex items-center p-3 border border-gray-600 rounded-lg cursor-pointer hover:bg-gray-800/50">
                        <input type="radio" name="category_type" value="main" checked 
                               class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-600 focus:ring-blue-500 focus:ring-2"
                               onchange="toggleParentSelect(false)">
                        <div class="ml-3">
                            <span class="block text-white font-medium">Main Category</span>
                            <span class="block text-gray-400 text-sm">Create a new top-level category (recommended for new categories)</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-3 border border-gray-600 rounded-lg cursor-pointer hover:bg-gray-800/50">
                        <input type="radio" name="category_type" value="sub"
                               class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-600 focus:ring-blue-500 focus:ring-2"
                               onchange="toggleParentSelect(true)">
                        <div class="ml-3">
                            <span class="block text-white font-medium">Subcategory</span>
                            <span class="block text-gray-400 text-sm">Create a subcategory under an existing main category</span>
                        </div>
                    </label>
                </div>
                
                <!-- Parent selection (hidden by default) -->
                <div id="parentSelectContainer" style="display: none;">
                    <label for="parent_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Select Parent Category <span class="text-red-400">*</span>
                    </label>
                    <select id="parent_id" 
                            name="parent_id" 
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose a parent category...</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" 
                                    {{ (old('parent_id') ?: request('parent')) == $parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->name }} ({{ $parentCategory->name_ar }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                @error('parent_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- English Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">English Name *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="e.g., Web Development or Laravel Basics"
                       required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Arabic Name -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-300 mb-2">
                    Category Name (Arabic) <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       id="name_ar" 
                       name="name_ar" 
                       value="{{ old('name_ar') }}"
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="e.g., التكنولوجيا، تطوير الويب"
                       dir="rtl"
                       required>
                @error('name_ar')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-300 mb-2">
                    URL Slug <span class="text-gray-500">(Optional - auto-generated from name)</span>
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug') }}"
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="e.g., technology, web-development">
                <p class="text-gray-500 text-sm mt-1">Used in URLs. Leave blank to auto-generate from the English name.</p>
                @error('slug')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Description <span class="text-gray-500">(Optional)</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-2">
                    Sort Order <span class="text-gray-500">(Optional)</span>
                </label>
                <input type="number" 
                       id="sort_order" 
                       name="sort_order" 
                       value="{{ old('sort_order') }}"
                       min="0"
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="e.g., 10, 20, 30">
                <p class="text-gray-500 text-sm mt-1">Lower numbers appear first. Leave blank for automatic ordering.</p>
                @error('sort_order')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-300">
                        Active Category
                    </label>
                </div>
                <p class="text-gray-500 text-sm mt-1">Only active categories will be available for article assignment.</p>
                @error('is_active')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-700">
                <a href="{{ route('admin.categories.index') }}" 
                   class="px-4 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from name if slug is empty
    document.getElementById('name').addEventListener('input', function() {
        const slugField = document.getElementById('slug');
        if (!slugField.value) {
            const name = this.value;
            const slug = name
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugField.value = slug;
        }
    });

    function toggleParentSelect(isSubcategory) {
        const parentSelectContainer = document.getElementById('parentSelectContainer');
        if (isSubcategory) {
            parentSelectContainer.style.display = 'block';
        } else {
            parentSelectContainer.style.display = 'none';
        }
    }
</script>
@endpush
@endsection 
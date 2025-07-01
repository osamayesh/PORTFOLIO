@extends('layouts.admin')

@section('title', 'Add New Summary')
@section('page-title', 'Add New Summary')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="admin-card rounded-lg p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">Create New Summary</h2>
            <p class="text-gray-400">Add a new PDF summary with English and Arabic translations</p>
        </div>

        <form method="POST" action="{{ route('admin.summaries.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- English Content -->
            <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">English Content</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="title_en" class="block text-sm font-medium text-gray-300 mb-2">Title (English) *</label>
                        <input type="text" id="title_en" name="title_en" value="{{ old('title_en') }}" 
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter English title..." required>
                        @error('title_en')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description_en" class="block text-sm font-medium text-gray-300 mb-2">Description (English) *</label>
                        <textarea id="description_en" name="description_en" rows="4" 
                                  class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Enter English description..." required>{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Arabic Content -->
            <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">Arabic Content (المحتوى العربي)</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="title_ar" class="block text-sm font-medium text-gray-300 mb-2">Title (Arabic) * العنوان</label>
                        <input type="text" id="title_ar" name="title_ar" value="{{ old('title_ar') }}" 
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-right"
                               placeholder="أدخل العنوان بالعربية..." required dir="rtl">
                        @error('title_ar')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description_ar" class="block text-sm font-medium text-gray-300 mb-2">Description (Arabic) * الوصف</label>
                        <textarea id="description_ar" name="description_ar" rows="4" 
                                  class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-right"
                                  placeholder="أدخل الوصف بالعربية..." required dir="rtl">{{ old('description_ar') }}</textarea>
                        @error('description_ar')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- PDF Upload -->
            <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">PDF File Upload</h3>
                
                <div>
                    <label for="pdf_file" class="block text-sm font-medium text-gray-300 mb-2">PDF File *</label>
                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-gray-500 transition-colors duration-300">
                        <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" 
                               class="hidden" onchange="updateFileName(this)" required>
                        <label for="pdf_file" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-gray-300 font-medium">Click to upload PDF file</p>
                            <p class="text-gray-500 text-sm">Maximum file size: 10MB</p>
                        </label>
                        <p id="file-name" class="text-green-400 text-sm mt-2 hidden"></p>
                    </div>
                    @error('pdf_file')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Settings -->
            <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">Settings & Configuration</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                        <select id="category" name="category" 
                                class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="color_scheme" class="block text-sm font-medium text-gray-300 mb-2">Color Scheme *</label>
                        <select id="color_scheme" name="color_scheme" 
                                class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Select Color</option>
                            @foreach($colorSchemes as $color)
                                <option value="{{ $color }}" {{ old('color_scheme') === $color ? 'selected' : '' }}>
                                    {{ ucfirst($color) }}
                                </option>
                            @endforeach
                        </select>
                        @error('color_scheme')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="published_date" class="block text-sm font-medium text-gray-300 mb-2">Published Date *</label>
                        <input type="date" id="published_date" name="published_date" value="{{ old('published_date', date('Y-m-d')) }}" 
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        @error('published_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-2">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="0">
                        @error('sort_order')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center pt-8">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="is_active" class="ml-2 text-sm font-medium text-gray-300">Active (visible to public)</label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                <a href="{{ route('admin.summaries.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors duration-300">
                    Cancel
                </a>
                
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition-colors duration-300 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Create Summary</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updateFileName(input) {
    const fileName = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        fileName.textContent = `Selected: ${input.files[0].name}`;
        fileName.classList.remove('hidden');
    } else {
        fileName.classList.add('hidden');
    }
}
</script>
@endpush
@endsection 
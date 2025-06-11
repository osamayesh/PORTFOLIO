@extends('layouts.admin')

@section('title', 'Edit Summary')
@section('page-title', 'Edit Summary')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="admin-card rounded-lg p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">Edit Summary</h2>
            <p class="text-gray-400">Update PDF summary and translations</p>
        </div>

        <form method="POST" action="{{ route('admin.summaries.update', $summary) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- English Content -->
            <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">English Content</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="title_en" class="block text-sm font-medium text-gray-300 mb-2">Title (English) *</label>
                        <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $summary->title_en) }}" 
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
                                  placeholder="Enter English description..." required>{{ old('description_en', $summary->description_en) }}</textarea>
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
                        <input type="text" id="title_ar" name="title_ar" value="{{ old('title_ar', $summary->title_ar) }}" 
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
                                  placeholder="أدخل الوصف بالعربية..." required dir="rtl">{{ old('description_ar', $summary->description_ar) }}</textarea>
                        @error('description_ar')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Current PDF & Upload New -->
            <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">PDF File</h3>
                
                <!-- Current PDF -->
                @if($summary->pdf_file_path)
                <div class="mb-4 p-4 bg-gray-700/50 rounded-lg border border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <svg class="w-8 h-8 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                            </svg>
                            <div>
                                <p class="text-white font-medium">Current PDF</p>
                                <p class="text-gray-400 text-sm">{{ $summary->pdf_file_path }}</p>
                            </div>
                        </div>
                        <a href="{{ $summary->getPdfUrl() }}" target="_blank" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>View</span>
                        </a>
                    </div>
                </div>
                @endif
                
                <!-- Upload New PDF -->
                <div>
                    <label for="pdf_file" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ $summary->pdf_file_path ? 'Replace PDF File (Optional)' : 'PDF File *' }}
                    </label>
                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-gray-500 transition-colors duration-300">
                        <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" 
                               class="hidden" onchange="updateFileName(this)" {{ !$summary->pdf_file_path ? 'required' : '' }}>
                        <label for="pdf_file" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-gray-300 font-medium">
                                {{ $summary->pdf_file_path ? 'Click to replace PDF file' : 'Click to upload PDF file' }}
                            </p>
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
                                <option value="{{ $category }}" {{ old('category', $summary->category) === $category ? 'selected' : '' }}>
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
                                <option value="{{ $color }}" {{ old('color_scheme', $summary->color_scheme) === $color ? 'selected' : '' }}>
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
                        <input type="date" id="published_date" name="published_date" value="{{ old('published_date', $summary->published_date->format('Y-m-d')) }}" 
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        @error('published_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-2">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $summary->sort_order) }}" min="0"
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="0">
                        @error('sort_order')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center pt-8">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $summary->is_active) ? 'checked' : '' }}
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
                
                <div class="flex items-center space-x-3">
                    <a href="{{ $summary->getPdfUrl() }}" target="_blank"
                       class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors duration-300 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Preview</span>
                    </a>
                    
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition-colors duration-300 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Update Summary</span>
                    </button>
                </div>
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
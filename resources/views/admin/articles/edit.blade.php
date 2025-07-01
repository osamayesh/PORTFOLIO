@extends('layouts.admin')

@section('title', 'Edit Article')
@section('page-title', 'Edit Article')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Edit Article</h2>
            <p class="text-gray-400">Update article content and settings</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                View Article
            </a>
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                Back to Articles
            </a>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="space-y-6" id="article-form">
        @csrf
        @method('PUT')
        
        <!-- Hidden field to track article ID for validation -->
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- English Content -->
                <div class="admin-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm mr-2">EN</span>
                        English Content
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- English Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Title (English) *</label>
                            <input type="text" name="title_en" value="{{ old('title_en', $article->title_en ?? $article->title) }}" required
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                   placeholder="Enter article title in English">
                            @error('title_en')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- English Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Description (English) *</label>
                            <textarea name="description_en" rows="3" required
                                      class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                      placeholder="Brief description of the article in English">{{ old('description_en', $article->description_en ?? $article->description) }}</textarea>
                            @error('description_en')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- English Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Content (English) *</label>
                            <input id="content_en" type="hidden" name="content_en" value="{{ old('content_en', $article->content_en ?? $article->content) }}" required>
                            <div id="editor_en_container">
                                <div id="editor_en" class="quill-editor-en"></div>
                            </div>
                            @error('content_en')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Code Snippets -->
                <div class="admin-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <span class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm mr-2">&lt;/&gt;</span>
                        Code Snippets
                        <span class="text-gray-400 text-sm font-normal ml-2">(Optional)</span>
                        <button type="button" id="addCodeSnippet" class="ml-auto bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            + Add Snippet
                        </button>
                    </h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-400 text-sm">
                            Code snippets are optional. Click "+ Add Snippet" to include code examples in your article.
                        </p>
                    </div>
                    
                    <div id="codeSnippetsContainer">
                        <!-- Existing code snippets will be loaded here -->
                    </div>
                </div>

                <!-- Comparison Tables -->
                <div class="admin-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-sm mr-2">📊</span>
                        Comparison Tables
                        <span class="text-gray-400 text-sm font-normal ml-2">(Optional)</span>
                        <button type="button" id="addComparisonTable" class="ml-auto bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            + Add Table
                        </button>
                    </h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-400 text-sm">
                            Comparison tables are optional. Click "+ Add Table" to include feature comparisons, specifications, or pros/cons in your article.
                        </p>
                    </div>
                    
                    <div id="comparisonTablesContainer">
                        <!-- Existing comparison tables will be loaded here -->
                    </div>
                </div>

                <!-- Arabic Content -->
                <div class="admin-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-sm mr-2">AR</span>
                        Arabic Content
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Arabic Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Title (Arabic) *</label>
                            <input type="text" name="title_ar" value="{{ old('title_ar', $article->title_ar) }}" required dir="rtl"
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                   placeholder="أدخل عنوان المقال بالعربية">
                            @error('title_ar')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arabic Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Description (Arabic) *</label>
                            <textarea name="description_ar" rows="3" required dir="rtl"
                                      class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                      placeholder="وصف مختصر للمقال بالعربية">{{ old('description_ar', $article->description_ar) }}</textarea>
                            @error('description_ar')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arabic Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Content (Arabic) *</label>
                            <input id="content_ar" type="hidden" name="content_ar" value="{{ old('content_ar', $article->content_ar) }}" required>
                            <div id="editor_ar_container" dir="rtl">
                                <div id="editor_ar" class="quill-editor-ar"></div>
                            </div>
                            @error('content_ar')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Article Settings -->
                <div class="admin-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Article Settings</h3>
                    
                    <div class="space-y-4">
                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                            <select name="category_id" required
                                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    @if($category->isMainCategory())
                                    <option value="{{ $category->id }}" {{ (old('category_id', $article->category_id) == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name_ar }} ({{ $category->name }})
                                        </option>
                                        @foreach($category->children as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ (old('category_id', $article->category_id) == $subcategory->id) ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;└── {{ $subcategory->name_ar }} ({{ $subcategory->name }})
                                    </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags', is_array($article->tags) ? implode(', ', $article->tags) : '') }}"
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                   placeholder="tag1, tag2, tag3">
                            <p class="text-gray-400 text-xs mt-1">Separate tags with commas</p>
                            @error('tags')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Read Time -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Read Time (minutes)</label>
                            <input type="number" name="read_time" value="{{ old('read_time', $article->read_time) }}" min="1"
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                   placeholder="5">
                            @error('read_time')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Featured Image -->
                        @if($article->featured_image)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Current Featured Image</label>
                            <img src="{{ asset('storage/articles/' . $article->featured_image) }}" alt="Featured Image" class="w-full h-32 object-cover rounded-lg">
                        </div>
                        @endif

                        <!-- Featured Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">{{ $article->featured_image ? 'Replace Featured Image' : 'Featured Image' }}</label>
                            <input type="file" name="featured_image" accept="image/*"
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                            <p class="text-gray-400 text-xs mt-1">Max size: 2MB. Formats: JPG, PNG, GIF</p>
                            @error('featured_image')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Publishing Options -->
                <div class="admin-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        Publishing
                        @if($article->is_published)
                            <span class="ml-2 px-2 py-1 text-xs bg-green-500/20 text-green-300 rounded">PUBLISHED</span>
                        @else
                            <span class="ml-2 px-2 py-1 text-xs bg-orange-500/20 text-orange-300 rounded">DRAFT</span>
                        @endif
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Publication Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}
                                       class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500 focus:ring-offset-gray-800">
                                <span class="ml-2 text-gray-300">Publish to website</span>
                            </label>
                            <p class="text-gray-400 text-xs mt-1">
                                <span class="text-orange-300">⚠️ Unchecked = Draft (hidden from website)</span><br>
                                <span class="text-green-300">✓ Checked = Published (visible on website)</span>
                            </p>
                        </div>

                        <!-- Publish Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Publish Date</label>
                            <input type="datetime-local" name="published_at" 
                                   value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                            <p class="text-gray-400 text-xs mt-1">Leave empty to use current time</p>
                            @error('published_at')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Stats -->
                        <div class="pt-4 border-t border-gray-700">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-400">Views:</span>
                                    <span class="text-white font-medium">{{ number_format($article->views) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400">Created:</span>
                                    <span class="text-white font-medium">{{ $article->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="admin-card rounded-lg p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                            Update Article
                        </button>
                        <a href="{{ route('admin.articles.index') }}" class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Separate Delete Form -->
    <div class="mt-6">
        <div class="admin-card rounded-lg p-6">
            <h3 class="text-lg font-semibold text-red-400 mb-4">Danger Zone</h3>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                                Delete Article
                            </button>
                        </form>
                    </div>
                </div>
</div>

<!-- Quill Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<style>
/* Reset any conflicting styles first */
.quill-editor-en, .quill-editor-ar {
    isolation: isolate;
    contain: layout style;
}

/* English Editor Container */
#editor_en_container {
    direction: ltr !important;
    text-align: left !important;
}

#editor_en_container .ql-container {
    background-color: #374151 !important;
    color: #ffffff !important;
    border: 2px solid #6b7280 !important;
    border-top: none !important;
    border-radius: 0 0 0.75rem 0.75rem !important;
    min-height: 300px !important;
    font-size: 1rem !important;
    line-height: 1.6 !important;
    direction: ltr !important;
}

#editor_en_container .ql-editor {
    color: #ffffff !important;
    padding: 1rem !important;
    min-height: 300px !important;
    direction: ltr !important;
    text-align: left !important;
}

#editor_en_container .ql-toolbar {
    background-color: #4b5563 !important;
    border: 2px solid #6b7280 !important;
    border-bottom: none !important;
    border-radius: 0.75rem 0.75rem 0 0 !important;
    padding: 0.75rem !important;
    direction: ltr !important;
}

#editor_en_container .ql-toolbar .ql-formats {
    margin-right: 0.5rem !important;
    margin-left: 0 !important;
}

#editor_en_container .ql-editor ul, 
#editor_en_container .ql-editor ol {
    padding-left: 2rem !important;
    padding-right: 0 !important;
}

#editor_en_container .ql-editor blockquote {
    border-left: 4px solid #3b82f6 !important;
    border-right: none !important;
    background-color: rgba(59, 130, 246, 0.1) !important;
    padding: 1rem !important;
    margin: 1rem 0 !important;
    border-radius: 0.5rem !important;
}

/* Arabic Editor Container */
#editor_ar_container {
    direction: rtl !important;
    text-align: right !important;
}

#editor_ar_container .ql-container {
    background-color: #374151 !important;
    color: #ffffff !important;
    border: 2px solid #6b7280 !important;
    border-top: none !important;
    border-radius: 0 0 0.75rem 0.75rem !important;
    min-height: 300px !important;
    font-size: 1rem !important;
    line-height: 1.6 !important;
    direction: rtl !important;
}

#editor_ar_container .ql-editor {
    color: #ffffff !important;
    padding: 1rem !important;
    min-height: 300px !important;
    direction: rtl !important;
    text-align: right !important;
}

#editor_ar_container .ql-toolbar {
    background-color: #4b5563 !important;
    border: 2px solid #6b7280 !important;
    border-bottom: none !important;
    border-radius: 0.75rem 0.75rem 0 0 !important;
    padding: 0.75rem !important;
    direction: rtl !important;
}

#editor_ar_container .ql-toolbar .ql-formats {
    margin-left: 0.5rem !important;
    margin-right: 0 !important;
}

#editor_ar_container .ql-editor ul, 
#editor_ar_container .ql-editor ol {
    padding-right: 2rem !important;
    padding-left: 0 !important;
}

#editor_ar_container .ql-editor blockquote {
    border-right: 4px solid #3b82f6 !important;
    border-left: none !important;
    background-color: rgba(59, 130, 246, 0.1) !important;
    padding: 1rem !important;
    margin: 1rem 0 !important;
    border-radius: 0.5rem !important;
}

/* Shared toolbar styles for both editors */
.ql-toolbar button {
    color: #e5e7eb !important;
    border: 1px solid #9ca3af !important;
    border-radius: 0.25rem !important;
    margin: 0.125rem !important;
    padding: 0.25rem !important;
    transition: all 0.3s ease !important;
}

.ql-toolbar button:hover {
    background-color: #9ca3af !important;
    color: #ffffff !important;
}

.ql-toolbar button.ql-active {
    background-color: #3b82f6 !important;
    color: #ffffff !important;
    border-color: #2563eb !important;
}

.ql-toolbar .ql-picker-label {
    color: #e5e7eb !important;
    border: 1px solid #9ca3af !important;
    border-radius: 0.25rem !important;
}

.ql-toolbar .ql-picker-label:hover {
    background-color: #9ca3af !important;
    color: #ffffff !important;
}

.ql-toolbar .ql-picker-options {
    background-color: #374151 !important;
    border: 1px solid #6b7280 !important;
    border-radius: 0.5rem !important;
    color: #ffffff !important;
}

.ql-toolbar .ql-picker-item {
    color: #ffffff !important;
}

.ql-toolbar .ql-picker-item:hover {
    background-color: #4b5563 !important;
    color: #ffffff !important;
}



.ql-editor strong {
    color: #fbbf24 !important;
    font-weight: 600 !important;
}

.ql-editor em {
    color: #a78bfa !important;
}

.ql-editor a {
    color: #60a5fa !important;
    text-decoration: underline !important;
}

.ql-editor ul, .ql-editor ol {
    margin: 1rem 0 !important;
}

/* Content After Editors - English */
.content-after-en-container {
    direction: ltr !important;
    text-align: left !important;
}

.content-after-en-container .ql-container {
    background-color: #374151 !important;
    color: #ffffff !important;
    border: 2px solid #6b7280 !important;
    border-top: none !important;
    border-radius: 0 0 0.75rem 0.75rem !important;
    min-height: 150px !important;
    font-size: 0.9rem !important;
    line-height: 1.5 !important;
    direction: ltr !important;
}

.content-after-en-container .ql-editor {
    color: #ffffff !important;
    padding: 0.75rem !important;
    min-height: 150px !important;
    direction: ltr !important;
    text-align: left !important;
}

.content-after-en-container .ql-toolbar {
    background-color: #4b5563 !important;
    border: 2px solid #6b7280 !important;
    border-bottom: none !important;
    border-radius: 0.75rem 0.75rem 0 0 !important;
    padding: 0.5rem !important;
    direction: ltr !important;
}

.content-after-en-container .ql-toolbar .ql-formats {
    margin-right: 0.5rem !important;
    margin-left: 0 !important;
}

.content-after-en-container .ql-editor ul, 
.content-after-en-container .ql-editor ol {
    padding-left: 2rem !important;
    padding-right: 0 !important;
}

.content-after-en-container .ql-editor blockquote {
    border-left: 4px solid #3b82f6 !important;
    border-right: none !important;
}

/* Content After Editors - Arabic */
.content-after-ar-container {
    direction: rtl !important;
    text-align: right !important;
}

.content-after-ar-container .ql-container {
    background-color: #374151 !important;
    color: #ffffff !important;
    border: 2px solid #6b7280 !important;
    border-top: none !important;
    border-radius: 0 0 0.75rem 0.75rem !important;
    min-height: 150px !important;
    font-size: 0.9rem !important;
    line-height: 1.5 !important;
    direction: rtl !important;
}

.content-after-ar-container .ql-editor {
    color: #ffffff !important;
    padding: 0.75rem !important;
    min-height: 150px !important;
    direction: rtl !important;
    text-align: right !important;
}

.content-after-ar-container .ql-toolbar {
    background-color: #4b5563 !important;
    border: 2px solid #6b7280 !important;
    border-bottom: none !important;
    border-radius: 0.75rem 0.75rem 0 0 !important;
    padding: 0.5rem !important;
    direction: rtl !important;
}

.content-after-ar-container .ql-toolbar .ql-formats {
    margin-left: 0.5rem !important;
    margin-right: 0 !important;
}

.content-after-ar-container .ql-editor ul, 
.content-after-ar-container .ql-editor ol {
    padding-right: 2rem !important;
    padding-left: 0 !important;
}

.content-after-ar-container .ql-editor blockquote {
    border-right: 4px solid #3b82f6 !important;
    border-left: none !important;
}

/* Focus states */
.ql-container.ql-snow:focus-within {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
}

/* Placeholder styling */
.ql-editor.ql-blank::before {
    color: #9ca3af !important;
    font-style: normal !important;
}

/* Hide image upload */
.ql-toolbar button.ql-image {
    display: none !important;
}

/* Arabic toolbar specific adjustments */
#editor_ar_container .ql-toolbar .ql-formats:not(:first-child) {
    border-right: 1px solid #9ca3af !important;
    border-left: none !important;
    padding-right: 0.5rem !important;
    padding-left: 0 !important;
    margin-right: 0.5rem !important;
    margin-left: 0 !important;
}

/* English toolbar specific adjustments */
#editor_en_container .ql-toolbar .ql-formats:not(:first-child) {
    border-left: 1px solid #9ca3af !important;
    border-right: none !important;
    padding-left: 0.5rem !important;
    padding-right: 0 !important;
    margin-left: 0.5rem !important;
    margin-right: 0 !important;
}
</style>

@push('scripts')
<script>
// Global variables
let quillEn, quillAr;
let contentAfterEditors = {};
let editorsInitialized = false;

document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit to ensure DOM is fully loaded
    setTimeout(() => {
        initializeQuillEditors();
        initializeExistingContentAfterEditors();
    }, 100);
});

function initializeQuillEditors() {
    if (editorsInitialized) return;
    
    // Destroy existing editors if they exist
    if (quillEn) {
        try { quillEn = null; } catch(e) {}
    }
    if (quillAr) {
        try { quillAr = null; } catch(e) {}
    }
    
    // English Editor Configuration
    const englishToolbarConfig = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean'],
        ['link']
    ];

    // Arabic Editor Configuration - intentionally different from English
    const arabicToolbarConfig = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean'],
        ['link']
    ];

    // Initialize English Editor
    const englishContainer = document.getElementById('editor_en');
    if (englishContainer) {
        quillEn = new Quill('#editor_en', {
            theme: 'snow',
            placeholder: 'Write your article content in English...',
            modules: {
                toolbar: englishToolbarConfig
            }
        });

        // Set initial content
        const contentEn = document.getElementById('content_en').value;
        if (contentEn) {
            quillEn.root.innerHTML = contentEn;
        }

        // Force LTR direction after initialization
        quillEn.root.setAttribute('dir', 'ltr');
        quillEn.root.style.direction = 'ltr';
        quillEn.root.style.textAlign = 'left';

        // Update hidden field on content change
        let enTimeout;
        quillEn.on('text-change', function() {
            clearTimeout(enTimeout);
            enTimeout = setTimeout(() => {
                document.getElementById('content_en').value = quillEn.root.innerHTML;
            }, 300);
        });
    }

    // Initialize Arabic Editor
    const arabicContainer = document.getElementById('editor_ar');
    if (arabicContainer) {
        quillAr = new Quill('#editor_ar', {
            theme: 'snow',
            placeholder: 'اكتب محتوى المقال بالعربية...',
            modules: {
                toolbar: arabicToolbarConfig
            }
        });

        // Set initial content
        const contentAr = document.getElementById('content_ar').value;
        if (contentAr) {
            quillAr.root.innerHTML = contentAr;
        }

        // Force RTL direction after initialization
        quillAr.root.setAttribute('dir', 'rtl');
        quillAr.root.style.direction = 'rtl';
        quillAr.root.style.textAlign = 'right';

        // Update hidden field on content change
        let arTimeout;
        quillAr.on('text-change', function() {
            clearTimeout(arTimeout);
            arTimeout = setTimeout(() => {
                document.getElementById('content_ar').value = quillAr.root.innerHTML;
            }, 300);
        });
    }

    // Form submission handler
    const form = document.getElementById('article-form');
    if (form) {
        form.addEventListener('submit', function() {
            // Force update all editors before submission
            if (quillEn) {
                document.getElementById('content_en').value = quillEn.root.innerHTML;
            }
            if (quillAr) {
                document.getElementById('content_ar').value = quillAr.root.innerHTML;
            }
            
            // Update all content after editors
            Object.keys(contentAfterEditors).forEach(editorId => {
                const editorObj = contentAfterEditors[editorId];
                if (editorObj && editorObj.editor && editorObj.hiddenInputId) {
                    const hiddenInput = document.getElementById(editorObj.hiddenInputId);
                    if (hiddenInput) {
                        hiddenInput.value = editorObj.editor.root.innerHTML;
                    }
                }
            });
        });
    }
    
    editorsInitialized = true;
}

function initializeExistingContentAfterEditors() {
    document.querySelectorAll('.quill-editor-content-after').forEach(editorDiv => {
        const editorId = editorDiv.id;
        const lang = editorDiv.dataset.lang;
        const snippetIndex = editorDiv.dataset.snippetIndex;
        
        if (contentAfterEditors[editorId]) {
            return; // Already initialized
        }
        
        const hiddenInputId = `content_after_${lang}_${snippetIndex}`;
        const hiddenInput = document.getElementById(hiddenInputId);
        
        if (hiddenInput) {
            initializeContentAfterEditor(editorId, hiddenInputId, lang);
        }
    });
}

function initializeContentAfterEditor(editorId, hiddenInputId, lang) {
    const hiddenInput = document.getElementById(hiddenInputId);
    const isArabic = lang === 'ar';
    
    const contentAfterToolbar = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote'],
        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        ['clean'],
        ['link']
    ];
    
    const editor = new Quill(`#${editorId}`, {
        theme: 'snow',
        placeholder: isArabic ? 'استمر محتوى المقال هنا...' : 'Continue your article content here...',
        modules: {
            toolbar: contentAfterToolbar
        }
    });
    
    // Set direction after initialization
    if (isArabic) {
        editor.root.setAttribute('dir', 'rtl');
        editor.root.style.direction = 'rtl';
        editor.root.style.textAlign = 'right';
    } else {
        editor.root.setAttribute('dir', 'ltr');
        editor.root.style.direction = 'ltr';
        editor.root.style.textAlign = 'left';
    }
    
    if (hiddenInput && hiddenInput.value) {
        editor.root.innerHTML = hiddenInput.value;
    }
    
    contentAfterEditors[editorId] = {
        editor: editor,
        hiddenInputId: hiddenInputId,
        lang: lang
    };
    
    let updateTimeout;
    editor.on('text-change', function() {
        clearTimeout(updateTimeout);
        updateTimeout = setTimeout(() => {
            if (hiddenInput) {
                hiddenInput.value = editor.root.innerHTML;
            }
        }, 300);
    });
}

let snippetCounter = 0;
const existingSnippets = @json($article->codeSnippets);

let tableCounter = 0;
const existingTables = @json($article->comparisonTables);

document.getElementById('addCodeSnippet').addEventListener('click', function() {
    addCodeSnippet();
});

document.getElementById('addComparisonTable').addEventListener('click', function() {
    addComparisonTable();
});

function addCodeSnippet(data = {}) {
    const container = document.getElementById('codeSnippetsContainer');
    const snippetId = `snippet_${snippetCounter}`;
    
    const snippetHtml = `
        <div class="code-snippet-form border border-gray-600 rounded-lg p-4 mb-4" data-snippet-id="${snippetId}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-white font-medium">Code Snippet #${snippetCounter + 1}</h4>
                <button type="button" class="remove-snippet text-red-400 hover:text-red-300 text-sm" onclick="removeSnippet('${snippetId}')">
                    Remove
                </button>
            </div>
            
            <!-- Hidden field for existing snippet ID -->
            ${data.id ? `<input type="hidden" name="code_snippets[${snippetCounter}][id]" value="${data.id}">` : ''}
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Title English -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Title (English)</label>
                    <input type="text" name="code_snippets[${snippetCounter}][title_en]" value="${data.title_en || ''}"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                           placeholder="Code example title">
                </div>
                
                <!-- Title Arabic -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Title (Arabic)</label>
                    <input type="text" name="code_snippets[${snippetCounter}][title_ar]" value="${data.title_ar || ''}" dir="rtl"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                           placeholder="عنوان مثال الكود">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Language -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Language</label>
                    <select name="code_snippets[${snippetCounter}][language]" 
                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500">
                        <option value="text" ${data.language === 'text' ? 'selected' : ''}>Plain Text</option>
                        <option value="c" ${data.language === 'c' ? 'selected' : ''}>C</option>
                        <option value="cpp" ${data.language === 'cpp' ? 'selected' : ''}>C++</option>
                        <option value="csharp" ${data.language === 'csharp' ? 'selected' : ''}>C#</option>
                        <option value="java" ${data.language === 'java' ? 'selected' : ''}>Java</option>
                        <option value="python" ${data.language === 'python' ? 'selected' : ''}>Python</option>
                        <option value="javascript" ${data.language === 'javascript' ? 'selected' : ''}>JavaScript</option>
                        <option value="php" ${data.language === 'php' ? 'selected' : ''}>PHP</option>
                        <option value="html" ${data.language === 'html' ? 'selected' : ''}>HTML</option>
                        <option value="css" ${data.language === 'css' ? 'selected' : ''}>CSS</option>
                        <option value="sql" ${data.language === 'sql' ? 'selected' : ''}>SQL</option>
                        <option value="bash" ${data.language === 'bash' ? 'selected' : ''}>Bash</option>
                        <option value="json" ${data.language === 'json' ? 'selected' : ''}>JSON</option>
                        <option value="xml" ${data.language === 'xml' ? 'selected' : ''}>XML</option>
                    </select>
                </div>
                
                <!-- Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Order</label>
                    <input type="number" name="code_snippets[${snippetCounter}][order]" value="${data.order !== undefined ? data.order : snippetCounter}"
                           min="0" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Filename -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Filename (optional)</label>
                    <input type="text" name="code_snippets[${snippetCounter}][filename]" value="${data.filename || ''}"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                           placeholder="example.c">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Description English -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description (English)</label>
                    <textarea name="code_snippets[${snippetCounter}][description_en]" rows="2"
                              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                              placeholder="Optional description">${data.description_en || ''}</textarea>
                </div>
                
                <!-- Description Arabic -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description (Arabic)</label>
                    <textarea name="code_snippets[${snippetCounter}][description_ar]" rows="2" dir="rtl"
                              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                              placeholder="وصف اختياري">${data.description_ar || ''}</textarea>
                </div>
            </div>
            
            <!-- Code -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-1">Code</label>
                <textarea name="code_snippets[${snippetCounter}][code]" rows="10" required
                          class="w-full px-3 py-2 bg-gray-900 border border-gray-600 rounded text-green-300 font-mono text-sm focus:outline-none focus:border-blue-500"
                          placeholder="Enter your code here...">${data.code || ''}</textarea>
            </div>
            
            <!-- Content After Code (Optional) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Continue Article Content After This Code Snippet (Optional)
                    <span class="text-gray-500 text-xs block mt-1">Add content that appears after this code snippet before the next one</span>
                </label>
                
                <div class="grid grid-cols-1 gap-4">
                    <!-- Content After (English) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">English Content</label>
                        <input id="content_after_en_${snippetCounter}" type="hidden" name="code_snippets[${snippetCounter}][content_after_en]" value="${data.content_after_en || ''}">
                        <div id="editor_content_after_en_container_${snippetCounter}" class="content-after-en-container">
                            <div id="editor_content_after_en_${snippetCounter}" class="quill-editor-content-after content-after-editor-en" data-snippet-index="${snippetCounter}" data-lang="en"></div>
                        </div>
                    </div>
                    
                    <!-- Content After (Arabic) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Arabic Content</label>
                        <input id="content_after_ar_${snippetCounter}" type="hidden" name="code_snippets[${snippetCounter}][content_after_ar]" value="${data.content_after_ar || ''}">
                        <div id="editor_content_after_ar_container_${snippetCounter}" class="content-after-ar-container" dir="rtl">
                            <div id="editor_content_after_ar_${snippetCounter}" class="quill-editor-content-after content-after-editor-ar" data-snippet-index="${snippetCounter}" data-lang="ar"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Options -->
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="code_snippets[${snippetCounter}][show_line_numbers]" value="1" 
                           ${data.show_line_numbers !== false ? 'checked' : ''}
                           class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-300 text-sm">Show line numbers</span>
                </label>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', snippetHtml);
    
    // Initialize content after editors for the new snippet
    setTimeout(() => {
        initializeExistingContentAfterEditors();
    }, 100);
    
    snippetCounter++;
}

function removeSnippet(snippetId) {
    const snippet = document.querySelector(`[data-snippet-id="${snippetId}"]`);
    if (snippet) {
        snippet.remove();
    }
}

// Load existing snippets on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load existing snippets only
    existingSnippets.forEach(function(snippet) {
        addCodeSnippet(snippet);
    });
    
    // Load existing comparison tables only
    existingTables.forEach(function(table) {
        addComparisonTable(table);
    });
    
    // Initialize content after editors for existing snippets
    setTimeout(() => {
        initializeExistingContentAfterEditors();
    }, 200);
});

function addComparisonTable(data = {}) {
    const container = document.getElementById('comparisonTablesContainer');
    const tableId = `table_${tableCounter}`;
    
    const tableHtml = `
        <div class="comparison-table-form border border-gray-600 rounded-lg p-4 mb-4" data-table-id="${tableId}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-white font-medium">Comparison Table #${tableCounter + 1}</h4>
                <button type="button" class="remove-table text-red-400 hover:text-red-300 text-sm" onclick="removeComparisonTable('${tableId}')">
                    Remove
                </button>
            </div>
            
            ${data.id ? `<input type="hidden" name="comparison_tables[${tableCounter}][id]" value="${data.id}">` : ''}
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Title English -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Title (English)</label>
                    <input type="text" name="comparison_tables[${tableCounter}][title_en]" value="${data.title_en || ''}"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                           placeholder="Table title">
                </div>
                
                <!-- Title Arabic -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Title (Arabic)</label>
                    <input type="text" name="comparison_tables[${tableCounter}][title_ar]" value="${data.title_ar || ''}" dir="rtl"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                           placeholder="عنوان الجدول">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Description English -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description (English)</label>
                    <textarea name="comparison_tables[${tableCounter}][description_en]" rows="2"
                              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                              placeholder="Optional description">${data.description_en || ''}</textarea>
                </div>
                
                <!-- Description Arabic -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description (Arabic)</label>
                    <textarea name="comparison_tables[${tableCounter}][description_ar]" rows="2" dir="rtl"
                              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                              placeholder="وصف اختياري">${data.description_ar || ''}</textarea>
                </div>
            </div>
            
            <!-- Table Builder -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-4">
                <!-- English Table -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Table Data (English)</label>
                    <div class="table-builder" data-lang="en" data-counter="${tableCounter}">
                        <div class="mb-2 flex gap-2">
                            <button type="button" class="add-column bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+ Column</button>
                            <button type="button" class="add-row bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+ Row</button>
                            <button type="button" class="remove-column bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">- Column</button>
                            <button type="button" class="remove-row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">- Row</button>
                        </div>
                        <div class="table-container bg-gray-800 rounded p-2 max-h-60 overflow-auto">
                            <table class="w-full border-collapse" id="table_en_${tableCounter}">
                                <!-- Will be populated by JavaScript -->
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="comparison_tables[${tableCounter}][table_data_en]" class="table-data-input">
                </div>
                
                <!-- Arabic Table -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Table Data (Arabic)</label>
                    <div class="table-builder" data-lang="ar" data-counter="${tableCounter}">
                        <div class="mb-2 flex gap-2" dir="rtl">
                            <button type="button" class="add-column bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+ عمود</button>
                            <button type="button" class="add-row bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+ صف</button>
                            <button type="button" class="remove-column bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">- عمود</button>
                            <button type="button" class="remove-row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">- صف</button>
                        </div>
                        <div class="table-container bg-gray-800 rounded p-2 max-h-60 overflow-auto" dir="rtl">
                            <table class="w-full border-collapse" id="table_ar_${tableCounter}">
                                <!-- Will be populated by JavaScript -->
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="comparison_tables[${tableCounter}][table_data_ar]" class="table-data-input">
                </div>
            </div>
            
            <!-- Options -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Order</label>
                    <input type="number" name="comparison_tables[${tableCounter}][order]" value="${data.order !== undefined ? data.order : tableCounter}"
                           min="0" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Style</label>
                    <select name="comparison_tables[${tableCounter}][table_style]" 
                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500">
                        <option value="default" ${data.table_style === 'default' ? 'selected' : ''}>Default</option>
                        <option value="compact" ${data.table_style === 'compact' ? 'selected' : ''}>Compact</option>
                        <option value="modern" ${data.table_style === 'modern' ? 'selected' : ''}>Modern</option>
                    </select>
                </div>
                
                <div class="flex items-center pt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="comparison_tables[${tableCounter}][show_header]" value="1" 
                               ${data.show_header !== false ? 'checked' : ''}
                               class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-300 text-sm">Show header</span>
                    </label>
                </div>
                
                <div class="flex items-center pt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="comparison_tables[${tableCounter}][striped_rows]" value="1" 
                               ${data.striped_rows !== false ? 'checked' : ''}
                               class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-300 text-sm">Striped rows</span>
                    </label>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', tableHtml);
    
    // Initialize table builders and load existing data
    initializeTableBuilders(tableId, data);
    
    tableCounter++;
}

function removeComparisonTable(tableId) {
    const table = document.querySelector(`[data-table-id="${tableId}"]`);
    if (table) {
        table.remove();
    }
}

function initializeTableBuilders(tableId, data = {}) {
    const tableForm = document.querySelector(`[data-table-id="${tableId}"]`);
    const builders = tableForm.querySelectorAll('.table-builder');
    
    builders.forEach(builder => {
        const lang = builder.dataset.lang;
        const counter = builder.dataset.counter;
        const table = builder.querySelector('table');
        
        // Load existing data or create default structure
        const tableData = data[`table_data_${lang}`] || { headers: ['Header 1', 'Header 2'], rows: [['Cell 1', 'Cell 2']] };
        buildTableFromData(table, tableData, lang);
        
        // Set up event listeners
        const addColumnBtn = builder.querySelector('.add-column');
        const addRowBtn = builder.querySelector('.add-row');
        const removeColumnBtn = builder.querySelector('.remove-column');
        const removeRowBtn = builder.querySelector('.remove-row');
        
        addColumnBtn.addEventListener('click', () => addTableColumn(table));
        addRowBtn.addEventListener('click', () => addTableRow(table));
        removeColumnBtn.addEventListener('click', () => removeTableColumn(table));
        removeRowBtn.addEventListener('click', () => removeTableRow(table));
        
        // Add event listeners to update hidden input when table changes
        table.addEventListener('input', () => updateTableData(builder));
        
        // Update hidden input with initial data
        updateTableData(builder);
    });
}

function buildTableFromData(table, data, lang) {
    const isRtl = lang === 'ar';
    let html = '<thead><tr>';
    
    // Build headers
    data.headers.forEach(header => {
        html += `<th class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" value="${header}" ${isRtl ? 'dir="rtl"' : ''}></th>`;
    });
    html += '</tr></thead><tbody>';
    
    // Build rows
    data.rows.forEach(row => {
        html += '<tr>';
        row.forEach(cell => {
            html += `<td class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" value="${cell}" ${isRtl ? 'dir="rtl"' : ''}></td>`;
        });
        html += '</tr>';
    });
    html += '</tbody>';
    
    table.innerHTML = html;
}

function addTableColumn(table) {
    const headerRow = table.querySelector('thead tr');
    const bodyRows = table.querySelectorAll('tbody tr');
    const lang = table.closest('.table-builder').dataset.lang;
    
    // Add header cell
    const headerCell = document.createElement('th');
    headerCell.className = 'border border-gray-600 p-1';
    headerCell.innerHTML = `<input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="${lang === 'ar' ? 'رأس جديد' : 'New Header'}" ${lang === 'ar' ? 'dir="rtl"' : ''}>`;
    headerRow.appendChild(headerCell);
    
    // Add body cells
    bodyRows.forEach(row => {
        const cell = document.createElement('td');
        cell.className = 'border border-gray-600 p-1';
        cell.innerHTML = `<input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="${lang === 'ar' ? 'خلية جديدة' : 'New Cell'}" ${lang === 'ar' ? 'dir="rtl"' : ''}>`;
        row.appendChild(cell);
    });
    
    updateTableData(table.closest('.table-builder'));
}

function addTableRow(table) {
    const tbody = table.querySelector('tbody');
    const columnCount = table.querySelector('thead tr').children.length;
    const lang = table.closest('.table-builder').dataset.lang;
    
    const row = document.createElement('tr');
    for (let i = 0; i < columnCount; i++) {
        const cell = document.createElement('td');
        cell.className = 'border border-gray-600 p-1';
        cell.innerHTML = `<input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="${lang === 'ar' ? 'خلية جديدة' : 'New Cell'}" ${lang === 'ar' ? 'dir="rtl"' : ''}>`; 
        row.appendChild(cell);
    }
    tbody.appendChild(row);
    
    updateTableData(table.closest('.table-builder'));
}

function removeTableColumn(table) {
    const headerRow = table.querySelector('thead tr');
    const bodyRows = table.querySelectorAll('tbody tr');
    
    if (headerRow.children.length > 1) {
        headerRow.removeChild(headerRow.lastElementChild);
        bodyRows.forEach(row => {
            if (row.children.length > 0) {
                row.removeChild(row.lastElementChild);
            }
        });
        updateTableData(table.closest('.table-builder'));
    }
}

function removeTableRow(table) {
    const tbody = table.querySelector('tbody');
    if (tbody.children.length > 1) {
        tbody.removeChild(tbody.lastElementChild);
        updateTableData(table.closest('.table-builder'));
    }
}

function updateTableData(builder) {
    const table = builder.querySelector('table');
    const hiddenInput = builder.parentElement.querySelector('.table-data-input');
    
    const headers = [];
    const rows = [];
    
    // Extract headers
    const headerCells = table.querySelectorAll('thead th input');
    headerCells.forEach(input => {
        headers.push(input.value);
    });
    
    // Extract rows
    const bodyRows = table.querySelectorAll('tbody tr');
    bodyRows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('td input');
        cells.forEach(input => {
            rowData.push(input.value);
        });
        rows.push(rowData);
    });
    
    const tableData = {
        headers: headers,
        rows: rows
    };
    
    hiddenInput.value = JSON.stringify(tableData);
}
</script>
@endpush

@endsection 
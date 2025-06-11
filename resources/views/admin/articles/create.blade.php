@extends('layouts.admin')

@section('title', 'Create Article')
@section('page-title', 'Create New Article')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Create Article</h2>
            <p class="text-gray-400">Add a new article to your blog</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
            Back to Articles
        </a>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="space-y-6" id="article-form">
        @csrf
        
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
                            <input type="text" name="title_en" value="{{ old('title_en', $formData['title_en'] ?? '') }}" required
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
                                      placeholder="Brief description of the article in English">{{ old('description_en', $formData['description_en'] ?? '') }}</textarea>
                            @error('description_en')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- English Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Content (English) *</label>
                            <input id="content_en" type="hidden" name="content_en" value="{{ old('content_en', $formData['content_en'] ?? '') }}" required>
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
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm mr-2">&lt;/&gt;</span>
                            Code Snippets
                        </div>
                        <button type="button" id="addCodeSnippet" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            + Add Snippet
                        </button>
                    </h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-400 text-sm">
                            Add code snippets to your article. 
                            <span class="text-blue-300">Click "+ Add Snippet" to add more code examples.</span>
                        </p>
                    </div>
                    
                    <div id="codeSnippetsContainer">
                        @for($i = 0; $i < 10; $i++)
                            <div class="code-snippet-form border border-gray-600 rounded-lg p-4 mb-4 {{ $i > 0 ? 'hidden' : '' }}" data-snippet-index="{{ $i }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-white font-medium">
                                        Code Snippet #{{ $i + 1 }}
                                        @if($i == 0)
                                            <span class="text-blue-300 text-sm font-normal">(First snippet)</span>
                                        @else
                                            <span class="text-gray-400 text-sm font-normal">(Optional)</span>
                                        @endif
                                    </h4>
                                    @if($i > 0)
                                        <button type="button" onclick="hideSnippet({{ $i }})" class="text-red-400 hover:text-red-300 text-sm transition-colors">
                                            Hide
                                        </button>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <!-- Title English -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Title (English)</label>
                                        <input type="text" name="code_snippets[{{ $i }}][title_en]" value="{{ old('code_snippets.'.$i.'.title_en', $formData['code_snippets'][$i]['title_en'] ?? '') }}"
                                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                               placeholder="Code example title">
                                    </div>
                                    
                                    <!-- Title Arabic -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Title (Arabic)</label>
                                        <input type="text" name="code_snippets[{{ $i }}][title_ar]" value="{{ old('code_snippets.'.$i.'.title_ar', $formData['code_snippets'][$i]['title_ar'] ?? '') }}" dir="rtl"
                                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                               placeholder="عنوان مثال الكود">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <!-- Language -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Language</label>
                                        <select name="code_snippets[{{ $i }}][language]" 
                                                class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500">
                                            @php
                                                $selectedLang = old('code_snippets.'.$i.'.language', $formData['code_snippets'][$i]['language'] ?? 'text');
                                            @endphp
                                            <option value="text" {{ $selectedLang === 'text' ? 'selected' : '' }}>Plain Text</option>
                                            <option value="c" {{ $selectedLang === 'c' ? 'selected' : '' }}>C</option>
                                            <option value="c#" {{ $selectedLang === 'c#' ? 'selected' : '' }}>C#</option>
                                            <option value="cpp" {{ $selectedLang === 'cpp' ? 'selected' : '' }}>C++</option>
                                            <option value="java" {{ $selectedLang === 'java' ? 'selected' : '' }}>Java</option>
                                            <option value="python" {{ $selectedLang === 'python' ? 'selected' : '' }}>Python</option>
                                            <option value="javascript" {{ $selectedLang === 'javascript' ? 'selected' : '' }}>JavaScript</option>
                                            <option value="php" {{ $selectedLang === 'php' ? 'selected' : '' }}>PHP</option>
                                            <option value="html" {{ $selectedLang === 'html' ? 'selected' : '' }}>HTML</option>
                                            <option value="css" {{ $selectedLang === 'css' ? 'selected' : '' }}>CSS</option>
                                            <option value="sql" {{ $selectedLang === 'sql' ? 'selected' : '' }}>SQL</option>
                                            <option value="bash" {{ $selectedLang === 'bash' ? 'selected' : '' }}>Bash</option>
                                            <option value="json" {{ $selectedLang === 'json' ? 'selected' : '' }}>JSON</option>
                                            <option value="xml" {{ $selectedLang === 'xml' ? 'selected' : '' }}>XML</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Order -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Order</label>
                                        <input type="number" name="code_snippets[{{ $i }}][order]" value="{{ old('code_snippets.'.$i.'.order', $formData['code_snippets'][$i]['order'] ?? $i + 1) }}"
                                               min="1" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                    
                                    <!-- Filename -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Filename (optional)</label>
                                        <input type="text" name="code_snippets[{{ $i }}][filename]" value="{{ old('code_snippets.'.$i.'.filename', $formData['code_snippets'][$i]['filename'] ?? '') }}"
                                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                               placeholder="example.{{ $i == 0 ? 'php' : ($i == 1 ? 'js' : ($i == 2 ? 'py' : ($i == 3 ? 'java' : 'txt'))) }}">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <!-- Description English -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Description (English)</label>
                                        <textarea name="code_snippets[{{ $i }}][description_en]" rows="2"
                                                  class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                                  placeholder="Optional description of this code snippet">{{ old('code_snippets.'.$i.'.description_en', $formData['code_snippets'][$i]['description_en'] ?? '') }}</textarea>
                                    </div>
                                    
                                    <!-- Description Arabic -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Description (Arabic)</label>
                                        <textarea name="code_snippets[{{ $i }}][description_ar]" rows="2" dir="rtl"
                                                  class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                                  placeholder="وصف اختياري لمثال الكود هذا">{{ old('code_snippets.'.$i.'.description_ar', $formData['code_snippets'][$i]['description_ar'] ?? '') }}</textarea>
                                    </div>
                                </div>
                                
                                <!-- Code -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-1">
                                        Code {{ $i == 0 ? '(Required if using snippets)' : '(Leave empty if not needed)' }}
                                    </label>
                                    <textarea name="code_snippets[{{ $i }}][code]" rows="8"
                                              class="w-full px-3 py-2 bg-gray-900 border border-gray-600 rounded text-green-300 font-mono text-sm focus:outline-none focus:border-blue-500"
                                              placeholder="{{ $i == 0 ? 'Enter your first code example here...' : 'Enter code here or leave empty...' }}">{{ old('code_snippets.'.$i.'.code', $formData['code_snippets'][$i]['code'] ?? '') }}</textarea>
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
                                            <input id="content_after_en_{{ $i }}" type="hidden" name="code_snippets[{{ $i }}][content_after_en]" value="{{ old('code_snippets.'.$i.'.content_after_en', $formData['code_snippets'][$i]['content_after_en'] ?? '') }}">
                                            <div id="editor_content_after_en_container_{{ $i }}" class="content-after-en-container">
                                                <div id="editor_content_after_en_{{ $i }}" class="quill-editor-content-after content-after-editor-en" data-snippet-index="{{ $i }}" data-lang="en"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Content After (Arabic) -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-400 mb-2">Arabic Content</label>
                                            <input id="content_after_ar_{{ $i }}" type="hidden" name="code_snippets[{{ $i }}][content_after_ar]" value="{{ old('code_snippets.'.$i.'.content_after_ar', $formData['code_snippets'][$i]['content_after_ar'] ?? '') }}">
                                            <div id="editor_content_after_ar_container_{{ $i }}" class="content-after-ar-container" dir="rtl">
                                                <div id="editor_content_after_ar_{{ $i }}" class="quill-editor-content-after content-after-editor-ar" data-snippet-index="{{ $i }}" data-lang="ar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Options -->
                                <div class="flex items-center">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="code_snippets[{{ $i }}][show_line_numbers]" value="1" 
                                               {{ old('code_snippets.'.$i.'.show_line_numbers', $formData['code_snippets'][$i]['show_line_numbers'] ?? true) ? 'checked' : '' }}
                                               class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-300 text-sm">Show line numbers</span>
                                    </label>
                                </div>
                            </div>
                        @endfor
                    </div>
                    
                    <div class="bg-gray-800 rounded-lg p-4 mt-4">
                        <h5 class="text-white font-medium mb-2">📝 How to use Code Snippets:</h5>
                        <ul class="text-gray-400 text-sm space-y-1">
                            <li>• Start with 1 snippet and add more as needed using the "+ Add Snippet" button</li>
                            <li>• Empty snippets will be automatically ignored when saving</li>
                            <li>• Use the "Order" field to control display sequence</li>
                            <li>• Both English and Arabic titles/descriptions are optional</li>
                            <li>• <strong>NEW:</strong> You can continue article content after each code snippet</li>
                            <li>• Add as many code snippets as you need - no limit!</li>
                        </ul>
                    </div>
                </div>

                <!-- Comparison Tables -->
                <div class="admin-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-sm mr-2">📊</span>
                            Comparison Tables
                        </div>
                        <button type="button" id="addComparisonTable" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            + Add Table
                        </button>
                    </h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-400 text-sm">
                            Add comparison tables to your article. Perfect for feature comparisons, pros/cons, specifications, etc.
                        </p>
                    </div>
                    
                    <div id="comparisonTablesContainer">
                        <!-- Tables will be added here dynamically -->
                    </div>
                    
                    <div class="bg-gray-800 rounded-lg p-4 mt-4">
                        <h5 class="text-white font-medium mb-2">📋 How to use Comparison Tables:</h5>
                        <ul class="text-gray-400 text-sm space-y-1">
                            <li>• Click "+ Add Table" to create a new comparison table</li>
                            <li>• Add headers and rows using the table builder</li>
                            <li>• Use simple text or basic HTML in table cells</li>
                            <li>• Empty tables will be automatically ignored when saving</li>
                            <li>• Both English and Arabic content can be provided</li>
                            <li>• Perfect for comparing features, specifications, or pros/cons</li>
                        </ul>
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
                            <input type="text" name="title_ar" value="{{ old('title_ar', $formData['title_ar'] ?? '') }}" required dir="rtl"
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
                                      placeholder="وصف مختصر للمقال بالعربية">{{ old('description_ar', $formData['description_ar'] ?? '') }}</textarea>
                            @error('description_ar')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arabic Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Content (Arabic) *</label>
                            <input id="content_ar" type="hidden" name="content_ar" value="{{ old('content_ar', $formData['content_ar'] ?? '') }}" required>
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
                                    <option value="{{ $category->id }}" {{ old('category_id', $formData['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_ar }} ({{ $category->name }})
                                        </option>
                                        @foreach($category->children as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('category_id', $formData['category_id'] ?? '') == $subcategory->id ? 'selected' : '' }}>
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
                            <input type="text" name="tags" value="{{ old('tags', $formData['tags'] ?? '') }}"
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
                            <input type="number" name="read_time" value="{{ old('read_time', $formData['read_time'] ?? '') }}" min="1"
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                   placeholder="5">
                            @error('read_time')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Featured Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Featured Image</label>
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
                    <h3 class="text-lg font-semibold text-white mb-4">Publishing</h3>
                    
                    <div class="space-y-4">
                        <!-- Publication Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
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
                            <input type="datetime-local" name="published_at" value="{{ old('published_at', $formData['published_at'] ?? '') }}"
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                            <p class="text-gray-400 text-xs mt-1">Leave empty to use current time</p>
                            @error('published_at')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="admin-card rounded-lg p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                            Create Article
                        </button>
                        <a href="{{ route('admin.articles.index') }}" class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

/* Content styling for both editors */
.ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6 {
    color: #60a5fa !important;
    font-weight: 600 !important;
    margin-top: 1.5rem !important;
    margin-bottom: 0.75rem !important;
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
    
    // Simple snippet management
    document.getElementById('addCodeSnippet').addEventListener('click', showNextSnippet);
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

// Simple snippet show/hide functions
function showNextSnippet() {
    const snippets = document.querySelectorAll('.code-snippet-form.hidden');
    if (snippets.length > 0) {
        snippets[0].classList.remove('hidden');
        // Initialize editors for the newly shown snippet
        setTimeout(() => {
            initializeExistingContentAfterEditors();
        }, 100);
    }
}

function hideSnippet(index) {
    const snippet = document.querySelector(`[data-snippet-index="${index}"]`);
    if (snippet && index > 0) { // Can't hide the first snippet
        snippet.classList.add('hidden');
        // Clear the form data
        const inputs = snippet.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            if (input.type === 'checkbox') {
                input.checked = input.hasAttribute('data-default-checked');
            } else {
                input.value = '';
            }
        });
        // Clear rich text editors
        const editorIds = [`editor_content_after_en_${index}`, `editor_content_after_ar_${index}`];
        editorIds.forEach(editorId => {
            if (contentAfterEditors[editorId]) {
                contentAfterEditors[editorId].editor.root.innerHTML = '';
                document.getElementById(`content_after_en_${index}`).value = '';
                document.getElementById(`content_after_ar_${index}`).value = '';
            }
        });
    }
}

// Comparison Table Management
let tableCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addComparisonTable').addEventListener('click', function() {
        addComparisonTable();
    });
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
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="Header 1"></th>
                                        <th class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="Header 2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="Cell 1"></td>
                                        <td class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="Cell 2"></td>
                                    </tr>
                                </tbody>
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
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="رأس 1" dir="rtl"></th>
                                        <th class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="رأس 2" dir="rtl"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="خلية 1" dir="rtl"></td>
                                        <td class="border border-gray-600 p-1"><input type="text" class="w-full bg-gray-700 text-white p-1 text-xs" placeholder="خلية 2" dir="rtl"></td>
                                    </tr>
                                </tbody>
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
    
    // Initialize table builders
    initializeTableBuilders(tableId);
    
    tableCounter++;
}

function removeComparisonTable(tableId) {
    const table = document.querySelector(`[data-table-id="${tableId}"]`);
    if (table) {
        table.remove();
    }
}

function initializeTableBuilders(tableId) {
    const tableForm = document.querySelector(`[data-table-id="${tableId}"]`);
    const builders = tableForm.querySelectorAll('.table-builder');
    
    builders.forEach(builder => {
        const addColumnBtn = builder.querySelector('.add-column');
        const addRowBtn = builder.querySelector('.add-row');
        const removeColumnBtn = builder.querySelector('.remove-column');
        const removeRowBtn = builder.querySelector('.remove-row');
        const table = builder.querySelector('table');
        
        addColumnBtn.addEventListener('click', () => addTableColumn(table));
        addRowBtn.addEventListener('click', () => addTableRow(table));
        removeColumnBtn.addEventListener('click', () => removeTableColumn(table));
        removeRowBtn.addEventListener('click', () => removeTableRow(table));
        
        // Add event listeners to update hidden input when table changes
        table.addEventListener('input', () => updateTableData(builder));
    });
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

@endsection 
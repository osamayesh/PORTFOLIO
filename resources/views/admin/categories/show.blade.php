@extends('layouts.admin')

@section('title', 'View Category')
@section('page-title', 'Category: ' . $category->name)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.categories.edit', $category) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Category
            </a>
        </div>
    </div>

    <!-- Category Information -->
    <div class="admin-card rounded-lg p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white mb-4">Category Information</h3>
                
                @if($category->parent)
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Parent Category</label>
                    <div class="flex items-center space-x-2">
                        <p class="text-blue-300 text-lg">{{ $category->parent->name }}</p>
                        <span class="text-gray-500">→</span>
                        <p class="text-white text-lg">{{ $category->name }}</p>
                    </div>
                    <p class="text-gray-400 text-sm" dir="rtl">{{ $category->parent->name_ar }} ← {{ $category->name_ar }}</p>
                </div>
                @else
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Category Type</label>
                    <p class="text-green-300 text-lg">Main Category</p>
                </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">English Name</label>
                    <p class="text-white text-lg">{{ $category->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Arabic Name</label>
                    <p class="text-white text-lg" dir="rtl">{{ $category->name_ar }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">URL Slug</label>
                    <p class="text-gray-300 font-mono">{{ $category->slug }}</p>
                </div>
                
                @if($category->description)
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Description</label>
                    <p class="text-gray-300">{{ $category->description }}</p>
                </div>
                @endif
            </div>
            
            <!-- Meta Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white mb-4">Details</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Status</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Sort Order</label>
                    <p class="text-white">{{ $category->sort_order ?? 'Not set' }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Created</label>
                    <p class="text-gray-300">{{ $category->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Last Updated</label>
                    <p class="text-gray-300">{{ $category->updated_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="admin-card rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Statistics</h3>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-blue-400">{{ $category->articles()->count() }}</p>
                <p class="text-gray-400">Total Articles</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-green-400">{{ $category->publishedArticles()->count() }}</p>
                <p class="text-gray-400">Published Articles</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-orange-400">{{ $category->articles()->where('is_published', false)->count() }}</p>
                <p class="text-gray-400">Draft Articles</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-purple-400">{{ $category->children->count() }}</p>
                <p class="text-gray-400">Subcategories</p>
            </div>
        </div>
    </div>

    <!-- Subcategories -->
    @if($category->isMainCategory() && $category->children->count() > 0)
    <div class="admin-card rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white">Subcategories</h3>
                <a href="{{ route('admin.categories.create') }}?parent={{ $category->id }}" 
                   class="text-blue-400 hover:text-blue-300 text-sm">Add Subcategory</a>
            </div>
        </div>

        <div class="divide-y divide-gray-700">
            @foreach($category->children as $subcategory)
            <div class="p-6 hover:bg-gray-800/50 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="text-white font-medium">{{ $subcategory->name }}</h4>
                        <p class="text-gray-400 text-sm" dir="rtl">{{ $subcategory->name_ar }}</p>
                        @if($subcategory->description)
                            <p class="text-gray-500 text-sm mt-1">{{ $subcategory->description }}</p>
                        @endif
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                            <span>{{ $subcategory->articles_count }} articles</span>
                            <span>Slug: {{ $subcategory->slug }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 ml-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subcategory->is_active ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                            {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('admin.categories.show', $subcategory) }}" 
                           class="text-blue-400 hover:text-blue-300 transition-colors duration-200" 
                           title="View Subcategory">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.categories.edit', $subcategory) }}" 
                           class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200" 
                           title="Edit Subcategory">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent Articles -->
    <div class="admin-card rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white">Recent Articles in this Category</h3>
                <a href="{{ route('admin.articles.index') }}?category={{ $category->id }}" 
                   class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
            </div>
        </div>

        @if($category->articles && $category->articles->count() > 0)
            <div class="divide-y divide-gray-700">
                @foreach($category->articles as $article)
                <div class="p-6 hover:bg-gray-800/50 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-white font-medium">{{ $article->title_en ?? $article->title }}</h4>
                            @if($article->excerpt)
                                <p class="text-gray-400 text-sm mt-1">{{ Str::limit($article->excerpt, 100) }}</p>
                            @endif
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>{{ $article->created_at->format('M d, Y') }}</span>
                                <span>{{ $article->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 ml-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->is_published ? 'bg-green-500/20 text-green-300' : 'bg-orange-500/20 text-orange-300' }}">
                                {{ $article->is_published ? 'Published' : 'Draft' }}
                            </span>
                            <a href="{{ route('admin.articles.edit', $article) }}" 
                               class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h4 class="text-lg font-medium text-gray-300 mb-2">No articles found</h4>
                <p class="text-gray-400 mb-4">No articles have been assigned to this category yet.</p>
                <a href="{{ route('admin.articles.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Article
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 
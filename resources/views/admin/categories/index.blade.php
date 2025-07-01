@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Manage Categories')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-400">Manage article categories and their organization</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Category
        </a>
    </div>

    <!-- Categories List -->
    <div class="admin-card rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-lg font-semibold text-white">Categories ({{ $categories->total() }})</h3>
        </div>

        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Arabic Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Articles</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($categories as $category)
                            <!-- Main Category Row -->
                            <tr class="hover:bg-gray-800/50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-white font-medium">{{ $category->name }}</p>
                                        @if($category->description)
                                            <p class="text-gray-400 text-sm">{{ Str::limit($category->description, 50) }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    {{ $category->name_ar }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-400 font-mono text-sm">{{ $category->slug }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/20 text-blue-300">
                                            {{ $category->articles_count }} {{ Str::plural('article', $category->articles_count) }}
                                        </span>
                                        @if($category->children->count() > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-300">
                                                {{ $category->children->count() }} {{ Str::plural('subcategory', $category->children->count()) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    {{ $category->sort_order }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($category->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-300">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-300">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="text-blue-400 hover:text-blue-300 transition-colors duration-200" 
                                           title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200" 
                                           title="Edit Category">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @if($category->articles_count == 0 && $category->children->count() == 0)
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category?')" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-400 hover:text-red-300 transition-colors duration-200" 
                                                        title="Delete Category">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Subcategories -->
                            @foreach($category->children as $subcategory)
                                <tr class="hover:bg-gray-800/50 bg-gray-900/30">
                                    <td class="px-6 py-4">
                                        <div class="ml-8 flex items-center">
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <div>
                                                <p class="text-gray-300 font-medium">{{ $subcategory->name }}</p>
                                                @if($subcategory->description)
                                                    <p class="text-gray-500 text-sm">{{ Str::limit($subcategory->description, 50) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $subcategory->name_ar }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-500 font-mono text-sm">{{ $subcategory->slug }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/20 text-blue-300">
                                            {{ $subcategory->articles_count }} {{ Str::plural('article', $subcategory->articles_count) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $subcategory->sort_order }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($subcategory->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-300">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-300">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.categories.show', $subcategory) }}" 
                                               class="text-blue-400 hover:text-blue-300 transition-colors duration-200" 
                                               title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $subcategory) }}" 
                                               class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200" 
                                               title="Edit Subcategory">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            @if($subcategory->articles_count == 0)
                                                <form method="POST" action="{{ route('admin.categories.destroy', $subcategory) }}" 
                                                      onsubmit="return confirm('Are you sure you want to delete this subcategory?')" 
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-400 hover:text-red-300 transition-colors duration-200" 
                                                            title="Delete Subcategory">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-700">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-300 mb-2">No categories found</h3>
                <p class="text-gray-400 mb-4">Get started by creating your first category.</p>
                <a href="{{ route('admin.categories.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Category
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 
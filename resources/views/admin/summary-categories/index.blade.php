@extends('layouts.admin')

@section('title', 'Summary Categories')
@section('page-title', 'Summary Categories Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-white">Summary Categories</h2>
        <a href="{{ route('admin.summary-categories.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add New Category</span>
        </a>
    </div>

    <!-- Categories Table -->
    <div class="admin-card rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="text-left py-3 px-4 text-gray-300 font-medium">Name</th>
                        <th class="text-left py-3 px-4 text-gray-300 font-medium">Slug</th>
                        <th class="text-left py-3 px-4 text-gray-300 font-medium">Color</th>
                        <th class="text-left py-3 px-4 text-gray-300 font-medium">Summaries</th>
                        <th class="text-left py-3 px-4 text-gray-300 font-medium">Status</th>
                        <th class="text-left py-3 px-4 text-gray-300 font-medium">Order</th>
                        <th class="text-left py-3 px-4 text-gray-300 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-700/30">
                        <td class="py-3 px-4">
                            <div>
                                <div class="text-white font-medium">{{ $category->name }}</div>
                                <div class="text-gray-400 text-sm">{{ $category->name_ar }}</div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-300 font-mono text-sm">{{ $category->slug }}</td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($category->color === 'blue') bg-blue-500/20 text-blue-300
                                @elseif($category->color === 'green') bg-green-500/20 text-green-300
                                @elseif($category->color === 'orange') bg-orange-500/20 text-orange-300
                                @elseif($category->color === 'purple') bg-purple-500/20 text-purple-300
                                @elseif($category->color === 'red') bg-red-500/20 text-red-300
                                @elseif($category->color === 'yellow') bg-yellow-500/20 text-yellow-300
                                @elseif($category->color === 'cyan') bg-cyan-500/20 text-cyan-300
                                @elseif($category->color === 'indigo') bg-indigo-500/20 text-indigo-300
                                @elseif($category->color === 'emerald') bg-emerald-500/20 text-emerald-300
                                @elseif($category->color === 'pink') bg-pink-500/20 text-pink-300
                                @else bg-gray-500/20 text-gray-300
                                @endif">
                                {{ ucfirst($category->color) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-300">{{ $category->summaries_count }}</td>
                        <td class="py-3 px-4">
                            <form action="{{ route('admin.summary-categories.toggle-status', $category) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2 py-1 rounded-full text-xs font-medium transition-colors duration-300
                                    {{ $category->is_active ? 'bg-green-500/20 text-green-300 hover:bg-green-500/30' : 'bg-red-500/20 text-red-300 hover:bg-red-500/30' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-4 text-gray-300">{{ $category->sort_order }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.summary-categories.show', $category) }}" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.summary-categories.edit', $category) }}" 
                                   class="text-green-400 hover:text-green-300 transition-colors duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @if($category->summaries_count == 0)
                                <form action="{{ route('admin.summary-categories.destroy', $category) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p>No summary categories found</p>
                            <a href="{{ route('admin.summary-categories.create') }}" class="text-blue-400 hover:text-blue-300 font-medium">Create your first category</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="px-4 py-3 border-t border-gray-700">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 
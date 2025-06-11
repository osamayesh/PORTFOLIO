@extends('layouts.admin')

@section('title', 'Manage Summaries')
@section('page-title', 'Summaries Management')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">All Summaries</h2>
            <p class="text-gray-400">Manage your PDF summaries and translations</p>
        </div>
        <a href="{{ route('admin.summaries.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-colors duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add New Summary</span>
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="admin-card rounded-lg p-6">
        <form method="GET" action="{{ route('admin.summaries.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search titles or descriptions..." 
                       class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                <select name="category" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Sort By</label>
                <select name="sort" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                    <option value="title_en" {{ request('sort') === 'title_en' ? 'selected' : '' }}>Title (EN)</option>
                    <option value="published_date" {{ request('sort') === 'published_date' ? 'selected' : '' }}>Published Date</option>
                    <option value="category" {{ request('sort') === 'category' ? 'selected' : '' }}>Category</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                    Filter
                </button>
                <a href="{{ route('admin.summaries.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Summaries Table -->
    <div class="admin-card rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Summary</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Published</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($summaries as $summary)
                    <tr class="hover:bg-gray-800/50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-{{ $summary->color_scheme }}-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-{{ $summary->color_scheme }}-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-medium">{{ $summary->title_en }}</p>
                                    <p class="text-gray-400 text-sm">{{ $summary->title_ar }}</p>
                                    <p class="text-gray-500 text-xs mt-1">{{ Str::limit($summary->description_en, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($summary->category === 'api') bg-blue-500/20 text-blue-300
                                @elseif($summary->category === 'git') bg-orange-500/20 text-orange-300
                                @elseif($summary->category === 'advanced') bg-purple-500/20 text-purple-300
                                @elseif($summary->category === 'books') bg-green-500/20 text-green-300
                                @elseif($summary->category === 'courses') bg-yellow-500/20 text-yellow-300
                                @else bg-gray-500/20 text-gray-300
                                @endif
                            ">
                                {{ ucfirst($summary->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="toggleStatus({{ $summary->id }})" 
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200
                                    {{ $summary->is_active ? 'bg-green-500/20 text-green-300 hover:bg-green-500/30' : 'bg-red-500/20 text-red-300 hover:bg-red-500/30' }}">
                                <span class="w-2 h-2 rounded-full mr-1 {{ $summary->is_active ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                <span id="status-text-{{ $summary->id }}">{{ $summary->is_active ? 'Active' : 'Inactive' }}</span>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-gray-300 text-sm">
                            {{ $summary->published_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <!-- View PDF -->
                                <a href="{{ $summary->getPdfUrl() }}" target="_blank" 
                                   class="text-green-400 hover:text-green-300 transition-colors duration-200" title="View PDF">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.summaries.edit', $summary) }}" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-200" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <!-- Delete -->
                                <form method="POST" action="{{ route('admin.summaries.destroy', $summary) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this summary? This action cannot be undone.')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors duration-200" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No summaries found</p>
                                <p class="text-sm">Get started by creating your first summary</p>
                                <a href="{{ route('admin.summaries.create') }}" class="inline-flex items-center mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Summary
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($summaries->hasPages())
        <div class="bg-gray-800 px-6 py-4 border-t border-gray-700">
            {{ $summaries->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
async function toggleStatus(summaryId) {
    try {
        const response = await fetch(`/admin/summaries/${summaryId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();
        
        if (data.success) {
            const statusText = document.getElementById(`status-text-${summaryId}`);
            const button = statusText.closest('button');
            const dot = button.querySelector('.w-2.h-2');
            
            if (data.status) {
                statusText.textContent = 'Active';
                button.className = button.className.replace('bg-red-500/20 text-red-300 hover:bg-red-500/30', 'bg-green-500/20 text-green-300 hover:bg-green-500/30');
                dot.className = dot.className.replace('bg-red-400', 'bg-green-400');
            } else {
                statusText.textContent = 'Inactive';
                button.className = button.className.replace('bg-green-500/20 text-green-300 hover:bg-green-500/30', 'bg-red-500/20 text-red-300 hover:bg-red-500/30');
                dot.className = dot.className.replace('bg-green-400', 'bg-red-400');
            }
        }
    } catch (error) {
        console.error('Error toggling status:', error);
        alert('Error updating status. Please try again.');
    }
}
</script>
@endpush
@endsection 
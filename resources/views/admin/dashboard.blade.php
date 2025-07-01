@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Header with Logout -->
    

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Summaries -->
        <div class="stat-card rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Summaries</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_summaries'] }}</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Summaries -->
        <div class="stat-card rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Active Summaries</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['active_summaries'] }}</p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Articles -->
        <div class="stat-card rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Articles</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_articles'] }}</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Published Articles -->
        <div class="stat-card rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Published Articles</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['published_articles'] }}</p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Draft Articles -->
        <div class="stat-card rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Draft Articles</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['draft_articles'] }}</p>
                </div>
                <div class="bg-orange-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Draft Articles Notice -->
    @if($stats['draft_articles'] > 0)
    <div class="bg-orange-600/20 border border-orange-600/30 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-orange-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <p class="text-orange-300 font-medium">You have {{ $stats['draft_articles'] }} draft article{{ $stats['draft_articles'] != 1 ? 's' : '' }}</p>
                <p class="text-orange-200 text-sm">Draft articles won't appear on the public articles page until published.</p>
            </div>
            <a href="{{ route('admin.articles.index') }}?status=draft" class="ml-auto bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-300">
                Review Drafts
            </a>
        </div>
    </div>
    @endif

    <!-- Category Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Summary Category Distribution -->
        <div class="admin-card rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Summary Categories</h3>
            <div class="space-y-3">
                @foreach($stats['summary_category_counts'] as $category => $count)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-3 
                            @if($category === 'api') bg-blue-400
                            @elseif($category === 'git') bg-orange-400
                            @elseif($category === 'advanced') bg-purple-400
                            @elseif($category === 'books') bg-green-400
                            @elseif($category === 'courses') bg-yellow-400
                            @else bg-gray-400
                            @endif
                        "></div>
                        <span class="text-gray-300 capitalize">{{ $category }}</span>
                    </div>
                    <span class="text-white font-medium">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Article Category Distribution -->
        <div class="admin-card rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Article Categories</h3>
            <div class="space-y-3">
                @forelse($stats['article_category_counts'] as $category => $count)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-3 bg-indigo-400"></div>
                        <span class="text-gray-300">{{ $category }}</span>
                    </div>
                    <span class="text-white font-medium">{{ $count }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">No article categories found</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Summaries -->
        <div class="admin-card rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Recent Summaries</h3>
                <a href="{{ route('admin.summaries.index') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($stats['recent_summaries'] as $summary)
                <div class="flex items-center justify-between py-2 border-b border-gray-700 last:border-b-0">
                    <div>
                        <p class="text-white font-medium">{{ Str::limit($summary->title_en, 30) }}</p>
                        <p class="text-gray-400 text-sm">{{ $summary->category }} • {{ $summary->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs rounded-full {{ $summary->is_active ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                            {{ $summary->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('admin.summaries.edit', $summary) }}" class="text-blue-400 hover:text-blue-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">No summaries found</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="admin-card rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Recent Articles <span class="text-sm text-gray-400 font-normal">(All)</span></h3>
                <a href="{{ route('admin.articles.index') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($stats['recent_articles'] as $article)
                <div class="flex items-center justify-between py-2 border-b border-gray-700 last:border-b-0">
                    <div>
                        <p class="text-white font-medium">{{ Str::limit($article->title_en ?? $article->title, 30) }}</p>
                        <p class="text-gray-400 text-sm">{{ $article->category->name_ar ?? 'No Category' }} • {{ $article->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs rounded-full {{ $article->is_published ? 'bg-green-500/20 text-green-300' : 'bg-orange-500/20 text-orange-300' }}">
                            {{ $article->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-400 hover:text-blue-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">No articles found</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <a href="{{ route('admin.summaries.create') }}" class="flex items-center p-4 bg-blue-600/20 hover:bg-blue-600/30 rounded-lg border border-blue-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <div>
                    <p class="text-white font-medium">Add Summary</p>
                    <p class="text-gray-400 text-sm">Create PDF summary</p>
                </div>
            </a>

            <a href="{{ route('admin.articles.create') }}" class="flex items-center p-4 bg-indigo-600/20 hover:bg-indigo-600/30 rounded-lg border border-indigo-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <div>
                    <p class="text-white font-medium">Add Article</p>
                    <p class="text-gray-400 text-sm">Create new article</p>
                </div>
            </a>

            <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 bg-teal-600/20 hover:bg-teal-600/30 rounded-lg border border-teal-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-teal-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <div>
                    <p class="text-white font-medium">Add Category</p>
                    <p class="text-gray-400 text-sm">Create new category</p>
                </div>
            </a>

            <a href="{{ route('admin.summaries.index') }}" class="flex items-center p-4 bg-green-600/20 hover:bg-green-600/30 rounded-lg border border-green-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-green-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                </svg>
                <div>
                    <p class="text-white font-medium">Manage Summaries</p>
                    <p class="text-gray-400 text-sm">Edit & organize</p>
                </div>
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center p-4 bg-yellow-600/20 hover:bg-yellow-600/30 rounded-lg border border-yellow-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <p class="text-white font-medium">Manage Articles</p>
                    <p class="text-gray-400 text-sm">Edit & publish</p>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center p-4 bg-cyan-600/20 hover:bg-cyan-600/30 rounded-lg border border-cyan-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <div>
                    <p class="text-white font-medium">Manage Categories</p>
                    <p class="text-gray-400 text-sm">Organize content</p>
                </div>
            </a>

            <a href="{{ url('/summaries') }}" target="_blank" class="flex items-center p-4 bg-purple-600/20 hover:bg-purple-600/30 rounded-lg border border-purple-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <div>
                    <p class="text-white font-medium">View Summaries</p>
                    <p class="text-gray-400 text-sm">Public page</p>
                </div>
            </a>

            <a href="{{ url('/articles') }}" target="_blank" class="flex items-center p-4 bg-pink-600/20 hover:bg-pink-600/30 rounded-lg border border-pink-600/30 transition-colors duration-300">
                <svg class="w-8 h-8 text-pink-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <div>
                    <p class="text-white font-medium">View Articles</p>
                    <p class="text-gray-400 text-sm">Public page</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection 
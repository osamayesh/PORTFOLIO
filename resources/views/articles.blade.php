@extends('layouts.app')

@section('title', 'Articles - Osama Ayesh')

@section('content')
<div class="container mx-auto max-w-6xl py-16">
    <!-- العنوان والوصف -->
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-5xl font-bold mb-8 section-title">
            📖 {{ app()->getLocale() === 'ar' ? 'المقالات' : 'Articles' }}
        </h2>
        <p class="text-lg text-gray-300 max-w-3xl mx-auto {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            @if(app()->getLocale() === 'ar')
            ستجد هنا بعض المقالات التي كتبتها عن أشياء مختلفة في عالم البرمجة، وأحببت أن أشاركها وتبسيط الأمور والإثراء المحتوى العربي، أرجوا أن تستفيدوا وتستمتعوا 😊
            @else
                Here you'll find articles I've written about various programming topics. I love sharing knowledge and simplifying complex concepts. I hope you find them useful and enjoyable! 😊
            @endif
        </p>
    </div>

    <!-- Category Filter Bar -->
    <div class="flex flex-wrap gap-3 justify-center mb-12">
        <a href="{{ route('articles.index') }}" 
           class="px-4 py-2 rounded-lg text-sm {{ !request()->has('category') ? 'bg-blue-500 text-white' : 'bg-gray-800 text-gray-300' }} 
           hover:bg-blue-600 transition-colors">
            {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
        </a>
        @foreach($categories as $category)
            <a href="{{ route('articles.category', $category->slug) }}" 
               class="px-4 py-2 rounded-lg text-sm {{ request()->segment(2) == $category->slug ? 'bg-blue-500 text-white' : 'bg-gray-800 text-gray-300' }} 
               hover:bg-blue-600 transition-colors">
                {{ app()->getLocale() === 'ar' ? $category->name_ar : ($category->name ?? $category->name_ar) }}
            </a>
        @endforeach
    </div>

    <div class="flex flex-col gap-8">
        <!-- محتوى المقالات -->
        <main class="w-full">
            <div class="text-center mb-16">
                <!-- Modern minimal header -->
                <div class="inline-flex items-center px-6 py-3 bg-gray-900 bg-opacity-40 rounded-full border border-gray-700 mb-6">
                    <h2 class="text-lg font-medium text-gray-300 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                        @if(request()->segment(2))
                            @php
                                $currentCategory = $categories->firstWhere('slug', request()->segment(2));
                            @endphp
                            {{ $currentCategory ? (app()->getLocale() === 'ar' ? $currentCategory->name_ar : ($currentCategory->name ?? $currentCategory->name_ar)) : (app()->getLocale() === 'ar' ? 'الفئة' : 'Category') }}
                        @else
                            {{ app()->getLocale() === 'ar' ? 'جميع المقالات' : 'All Articles' }}
                        @endif
                    </h2>
                </div>
                
                <!-- Large count with modern styling -->
                <div class="relative">
                    <span class="text-7xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 tracking-tighter">
                        {{ $articles->count() }}
                    </span>
                </div>
                
                <!-- Subtle subtitle -->
                <p class="text-sm text-gray-500 mt-2 font-light {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                    @if(app()->getLocale() === 'ar')
                        مقال{{ $articles->count() != 1 ? 'ة' : '' }} متاح{{ $articles->count() != 1 ? 'ة' : '' }}
                    @else
                        Available Article{{ $articles->count() != 1 ? 's' : '' }}
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($articles as $article)
                    <div class="bg-gray-900 bg-opacity-70 rounded-lg overflow-hidden article-card">
                        <div class="p-6">
                            <!-- Category Badge -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="px-3 py-1 text-xs rounded-full bg-blue-500 bg-opacity-20 text-blue-300">
                                    {{ $article->category->name_ar ?? $article->category->name }}
                                </span>
                                @if($article->programming_language)
                                    <span class="px-2 py-1 text-xs rounded bg-green-500 bg-opacity-20 text-green-300">
                                        {{ $article->programming_language }}
                                    </span>
                                @endif
                                @if($article->framework)
                                    <span class="px-2 py-1 text-xs rounded bg-purple-500 bg-opacity-20 text-purple-300">
                                        {{ $article->framework }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-2xl font-bold mb-3 text-blue-400 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ $article->getLocalizedTitle() }}
                                @if($article->series_id)
                                    <span class="text-sm text-blue-300 ml-2">({{ app()->getLocale() === 'ar' ? 'سلسلة' : 'Series' }})</span>
                                @endif
                            </h3>
                            
                            <p class="text-gray-300 mb-4 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ $article->getLocalizedDescription() }}
                            </p>

                            <!-- Prerequisites -->
                            @if($article->prerequisites && $article->prerequisites->count() > 0)
                                <div class="mb-4 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                    <p class="text-sm text-gray-400">
                                        {{ app()->getLocale() === 'ar' ? 'المتطلبات السابقة:' : 'Prerequisites:' }}
                                    </p>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach($article->prerequisites as $prereq)
                                            <a href="{{ route('articles.show', $prereq->slug) }}" 
                                               class="text-xs text-blue-400 hover:text-blue-300">
                                                • {{ $prereq->getLocalizedTitle() }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="flex flex-wrap justify-between items-center gap-4">
                                <span class="text-sm text-gray-400 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                    {{ $article->formatted_date }}
                                </span>
                                
                                <div class="flex items-center gap-2">
                                    <!-- Social Share Buttons -->
                                    <div class="flex items-center gap-1">
                                        <button onclick="copyToClipboard('{{ route('articles.show', $article->slug) }}')" 
                                                class="p-2 text-gray-400 hover:text-blue-400 transition-colors"
                                                title="{{ app()->getLocale() === 'ar' ? 'نسخ الرابط' : 'Copy Link' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                            </svg>
                                        </button>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('articles.show', $article->slug)) }}"
                                           target="_blank"
                                           class="p-2 text-gray-400 hover:text-blue-400 transition-colors"
                                           title="Twitter">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                            </svg>
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('articles.show', $article->slug)) }}"
                                           target="_blank"
                                           class="p-2 text-gray-400 hover:text-blue-400 transition-colors"
                                           title="LinkedIn">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                            </svg>
                                        </a>
                                    </div>

                                    <a href="{{ route('articles.show', $article->slug) }}" 
                                       class="px-4 py-2 rounded-md text-blue-400 border border-blue-500 article-btn">
                                        {{ app()->getLocale() === 'ar' ? 'قراءة المقالة' : 'Read Article' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        @if(request()->segment(2))
                            @php
                                $currentCategory = $categories->firstWhere('slug', request()->segment(2));
                            @endphp
                            <p class="text-gray-400 text-lg {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }} mb-2">لا توجد مقالات في فئة "{{ $currentCategory ? $currentCategory->name_ar : 'هذه الفئة' }}" حالياً</p>
                            <p class="text-gray-500 text-sm {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">تصفح الفئات الأخرى أو عد لاحقاً للمزيد من المحتوى</p>
                        @else
                            <p class="text-gray-400 text-lg {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }} mb-2">لا توجد مقالات منشورة حالياً</p>
                            <p class="text-gray-500 text-sm {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">عد لاحقاً للمزيد من المحتوى الجديد</p>
                        @endif
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection

@push('styles')
<style>
    .article-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(59, 130, 246, 0.1);
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .article-btn {
        transition: all 0.3s ease;
    }

    .article-btn:hover {
        background-color: rgba(59, 130, 246, 0.2);
    }

    .section-title {
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -10px;
        height: 3px;
        background: linear-gradient(90deg, #0dd3ff, transparent);
        border-radius: 3px;
    }

    .rtl {
        direction: rtl;
        text-align: right;
    }
    
    .ltr {
        direction: ltr;
        text-align: left;
    }
    
    /* Search input styles */
    .search-input {
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    /* Search results highlight */
    .search-highlight {
        background-color: rgba(59, 130, 246, 0.2);
        padding: 0 2px;
        border-radius: 2px;
    }
</style>
@endpush

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show a temporary tooltip or notification
        alert({{ app()->getLocale() === 'ar' ? '"تم نسخ الرابط!"' : '"Link copied!"' }});
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}
</script>
@endpush


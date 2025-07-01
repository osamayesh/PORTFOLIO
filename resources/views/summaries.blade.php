@extends('layouts.app')

@section('title', __('navigation.summaries') . ' - Portfolio - Osama Ayesh')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            <span class="texture-text">{{ __('navigation.summaries') }}</span>
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
            {{ app()->getLocale() === 'ar' ? 
                'سنجد هنا بعض الملخصات في هيئة ملفات توضيحية PDF تمت قد صممتها وأحببت أن أشاركها، أرجو أن تستفيدوا منها ويكون الملخص بسيط ووافي 😊' :
                'Here you will find some summaries in the form of PDF explanatory files that I have designed and would like to share. I hope you benefit from them and that the summary is simple and comprehensive 😊'
            }}
        </p>
        
       
    </div>

    <!-- Summary Categories Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-blue-400">{{ __('navigation.summaries') }}</h3>
                    <p class="text-2xl font-bold">{{ $categoryCounts['total'] }}</p>
                </div>
                <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Summaries Grid -->
    <div class="space-y-12">
        @if(isset($groupedSummaries['api']) && $groupedSummaries['api']->count() > 0)
        <!-- API World Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                </svg>
                <h2 class="text-3xl font-bold text-blue-400">{{ app()->getLocale() === 'ar' ? 'عالم الـ API' : 'API World' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['api'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['git']) && $groupedSummaries['git']->count() > 0)
        <!-- Git and Version Control Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-orange-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                </svg>
                <h2 class="text-3xl font-bold text-orange-400">{{ app()->getLocale() === 'ar' ? 'الـ Git وما وراءه' : 'Git and Beyond' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['git'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['advanced']) && $groupedSummaries['advanced']->count() > 0)
        <!-- Advanced Programming Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-purple-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>
                </svg>
                <h2 class="text-3xl font-bold text-purple-400">{{ app()->getLocale() === 'ar' ? 'متقدم' : 'Advanced' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['advanced'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['books']) && $groupedSummaries['books']->count() > 0)
        <!-- Books Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-green-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>
                </svg>
                <h2 class="text-3xl font-bold text-green-400">{{ app()->getLocale() === 'ar' ? 'الكتب' : 'Books' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['books'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['courses']) && $groupedSummaries['courses']->count() > 0)
        <!-- Courses Section -->
       
        @endif

        @if(isset($groupedSummaries['frameworks']) && $groupedSummaries['frameworks']->count() > 0)
        <!-- Frameworks Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-cyan-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>
                </svg>
                <h2 class="text-3xl font-bold text-cyan-400">{{ app()->getLocale() === 'ar' ? 'أطر العمل' : 'Frameworks' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['frameworks'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['databases']) && $groupedSummaries['databases']->count() > 0)
        <!-- Databases Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C9.243 2 7 2.895 7 4v2c0 1.105 2.243 2 5 2s5-.895 5-2V4c0-1.105-2.243-2-5-2zM7 8v2c0 1.105 2.243 2 5 2s5-.895 5-2V8c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 12v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 16v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2z"/>
                </svg>
                <h2 class="text-3xl font-bold text-yellow-400">{{ app()->getLocale() === 'ar' ? 'قواعد البيانات' : 'Databases' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['databases'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C9.243 2 7 2.895 7 4v2c0 1.105 2.243 2 5 2s5-.895 5-2V4c0-1.105-2.243-2-5-2zM7 8v2c0 1.105 2.243 2 5 2s5-.895 5-2V8c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 12v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 16v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['security']) && $groupedSummaries['security']->count() > 0)
        <!-- Security Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-red-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5zM10 17l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                </svg>
                <h2 class="text-3xl font-bold text-red-400">{{ app()->getLocale() === 'ar' ? 'الأمان' : 'Security' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['security'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5zM10 17l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['devops']) && $groupedSummaries['devops']->count() > 0)
        <!-- DevOps Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-indigo-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-10-5z"/>
                </svg>
                <h2 class="text-3xl font-bold text-indigo-400">{{ app()->getLocale() === 'ar' ? 'الـ DevOps' : 'DevOps' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['devops'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-10-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($groupedSummaries['documentation']) && $groupedSummaries['documentation']->count() > 0)
        <!-- Documentation Section -->
        <div class="bg-gray-800/30 backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 4h7v5h5v11H6V4z"/>
                </svg>
                <h2 class="text-3xl font-bold text-emerald-400">{{ app()->getLocale() === 'ar' ? 'التوثيق' : 'Documentation' }}</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($groupedSummaries['documentation'] as $summary)
                @php $colors = $summary->getColorClasses(); @endphp
                <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-600 {{ $colors['border'] }} transition-all duration-300 group">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="{{ $colors['bg'] }} p-3 rounded-lg {{ $colors['hover'] }} transition-colors duration-300">
                            <svg class="w-8 h-8 {{ $colors['text'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 4h7v5h5v11H6V4z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2 {{ $colors['hover_text'] }} transition-colors duration-300">
                                {{ $summary->getTitle() }}
                            </h3>
                            <p class="text-gray-400 mb-4 leading-relaxed">
                                {{ $summary->getDescription() }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $summary->getFormattedDate() }}
                                </span>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <!-- Browse Button -->
                                    <a href="{{ route('summaries.view', $summary->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تصفح' : 'Browse' }}</span>
                                    </a>
                                    <!-- Download Button -->
                                    <a href="{{ route('summaries.download', $summary->id) }}" class="{{ $colors['button'] }} text-white px-3 py-2 rounded-lg transition-colors duration-300 flex items-center space-x-1 rtl:space-x-reverse text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="text-center mt-16 mb-8">
        <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-xl p-8 border border-blue-500/30">
            <h3 class="text-2xl font-bold mb-4">
                {{ app()->getLocale() === 'ar' ? 'هل تريد المزيد من الملخصات؟' : 'Want more summaries?' }}
            </h3>
            <p class="text-gray-300 mb-6">
                {{ app()->getLocale() === 'ar' ? 
                    'تابعني على وسائل التواصل الاجتماعي للحصول على آخر الملخصات والمحتوى التقني' :
                    'Follow me on social media to get the latest summaries and technical content'
                }}
            </p>
            <div class="flex justify-center space-x-4 rtl:space-x-reverse">
                <a href="https://github.com/osamayesh" target="_blank" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition-colors duration-300 flex items-center space-x-2 rtl:space-x-reverse">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.117-3.176 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.372.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                    </svg>
                    <span>GitHub</span>
                </a>
                <a href="https://www.linkedin.com/in/osama-ayesh/" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-300 flex items-center space-x-2 rtl:space-x-reverse">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    <span>LinkedIn</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

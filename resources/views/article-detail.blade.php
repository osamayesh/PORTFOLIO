@extends('layouts.app')

@section('title', $article->title . ' - Osama Ayesh')

@section('meta')
<meta name="article-id" content="{{ $article->id }}">
@endsection

@section('content')
<!-- Reading Progress Bar -->
<div id="reading-progress" style="width: 0%;"></div>

<div class="container mx-auto max-w-7xl py-16">
    <!-- Article Header -->
    <div class="text-center mb-12">
        <div class="mb-4">
            <a href="{{ route('articles.category', $article->category->slug) }}" class="inline-block px-4 py-2 bg-blue-600 bg-opacity-20 text-blue-400 rounded-lg text-sm hover:bg-opacity-30 transition-all">
                {{ $article->category->name_ar }}
            </a>
        </div>
        <h1 class="text-3xl md:text-5xl font-bold mb-6 text-white {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">{{ $article->getLocalizedTitle() }}</h1>
        <div class="flex justify-center items-center gap-6 text-gray-400 text-sm">
            <span class="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">{{ $article->formatted_date }}</span>
            @if($article->read_time)
                <span>{{ $article->read_time }} دقائق قراءة</span>
            @endif
            <span>{{ $article->views }} مشاهدة</span>
        </div>
    </div>

    <!-- Table of Contents (Fixed Sidebar) -->
    <aside id="toc-container" class="hidden xl:block" 
           data-show-toc="{{ $article->show_toc ? 'true' : 'false' }}"
           data-toc-mode="{{ $article->toc_mode ?? 'auto' }}"
           data-toc-content="{{ $article->toc_content ? htmlspecialchars($article->toc_content) : '' }}">
        <div class="toc-sidebar rounded-lg p-6">
            <h3 class="text-lg font-bold text-blue-400 mb-4 flex items-center gap-2 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
                <span>{{ app()->getLocale() === 'ar' ? 'فهرس المحتوى' : 'Table of Contents' }}</span>
            </h3>
            <nav id="table-of-contents" class="space-y-1">
                <!-- Will be populated by JavaScript -->
            </nav>
        </div>
    </aside>

    <!-- Main Article Content -->
    <div class="article-main-content">
    <div class="bg-gray-900 bg-opacity-70 rounded-lg p-8 mb-8 article-container">
        <!-- Article Description -->
        <div class="mb-8 p-6 bg-blue-600 bg-opacity-10 rounded-lg border-l-4 border-blue-500 description-container">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg text-gray-300 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }} leading-relaxed">{{ $article->getLocalizedDescription() }}</p>
            </div>
        </div>

        <!-- Article Body -->
        <div class="prose prose-lg prose-invert max-w-none {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            <div class="text-gray-300 leading-relaxed article-content {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                {!! $article->getLocalizedContent() !!}
            </div>
        </div>

        <!-- Code Snippets -->
        @if($article->codeSnippets && count($article->codeSnippets) > 0)
            @foreach($article->codeSnippets as $snippet)
                <div class="my-8">
                    <h3 class="text-xl font-semibold text-blue-400 mb-4 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                        {{ $snippet->getLocalizedTitle() }}
                    </h3>
                    
                    @if($snippet->getLocalizedDescription())
                        <div class="mb-4 p-4 bg-blue-600 bg-opacity-10 rounded-lg border-l-4 border-blue-500">
                            <p class="text-gray-300 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">{{ $snippet->getLocalizedDescription() }}</p>
                        </div>
                    @endif
                    
                    <div class="code-snippet-container bg-gray-950 rounded-lg shadow-lg relative">
                        @if($snippet->getDisplayFilename())
                            <div class="px-4 py-2 bg-gray-800 rounded-t-lg border-b border-gray-700">
                                <span class="text-gray-400 text-sm font-mono">{{ $snippet->getDisplayFilename() }}</span>
                            </div>
                        @endif
                        
                        <button class="copy-button absolute top-2 right-2 bg-gray-700 hover:bg-gray-600 text-white text-xs px-2 py-1 rounded transition-all" onclick="copyCode(this)">
                            {{ app()->getLocale() === 'ar' ? 'نسخ' : 'Copy' }}
                        </button>
                        
                        <pre class="{{ $snippet->getCodeClasses() }} rounded-lg !bg-transparent p-6 !text-sm"><code class="{{ $snippet->getCodeClasses() }}">{{ $snippet->code }}</code></pre>
                    </div>
                    
                    <!-- Content After Code Snippet -->
                    @if($snippet->getLocalizedContentAfter())
                        <div class="mt-6 prose prose-lg prose-invert max-w-none {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            <div class="text-gray-300 leading-relaxed article-content {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {!! $snippet->getLocalizedContentAfter() !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        <!-- Comparison Tables -->
        @if($article->comparisonTables && count($article->comparisonTables) > 0)
            @foreach($article->comparisonTables as $table)
                <div class="my-8">
                    @if($table->getLocalizedTitle())
                        <h3 class="text-xl font-semibold text-green-400 mb-4 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            {{ $table->getLocalizedTitle() }}
                        </h3>
                    @endif
                    
                    @if($table->getLocalizedDescription())
                        <div class="mb-4 p-4 bg-green-600 bg-opacity-10 rounded-lg border-l-4 border-green-500">
                            <p class="text-gray-300 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">{{ $table->getLocalizedDescription() }}</p>
                        </div>
                    @endif
                    
                    @if($table->hasValidData())
                        <div class="comparison-table-container bg-gray-950 rounded-lg shadow-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="{{ $table->getTableClasses() }} {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                    @php
                                        $tableData = $table->getLocalizedTableData();
                                    @endphp
                                    
                                    @if($table->show_header && !empty($tableData['headers']))
                                        <thead class="bg-gray-800">
                                            <tr>
                                                @foreach($tableData['headers'] as $header)
                                                    <th class="px-4 py-3 text-left text-gray-300 font-semibold {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                                        {{ $header }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                    @endif
                                    
                                    @if(!empty($tableData['rows']))
                                        <tbody>
                                            @foreach($tableData['rows'] as $rowIndex => $row)
                                                <tr class="{{ $table->striped_rows && $rowIndex % 2 === 0 ? 'bg-gray-900' : 'bg-gray-800' }} hover:bg-gray-700 transition-colors">
                                                    @foreach($row as $cell)
                                                        <td class="px-4 py-3 text-gray-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                                            {!! $cell !!}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        <!-- Tags -->
        @if($article->tags && count($article->tags) > 0)
            <div class="mt-8 pt-6 border-t border-gray-700">
                <h3 class="text-lg font-semibold text-blue-400 mb-4 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }} flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'العلامات:' : 'Tags:' }}
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <span class="px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-sm font-medium border border-gray-600 hover:bg-gray-600 transition-colors">
                            #{{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    </div><!-- Close article-main-content -->

    <!-- Navigation -->
    <div class="flex justify-between items-center">
        <a href="{{ route('articles.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all">
            @if(app()->getLocale() === 'ar')
            ← العودة للمقالات
            @else
                ← Back to Articles
            @endif
        </a>
        <a href="{{ route('articles.category', $article->category->slug) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all">
            @if(app()->getLocale() === 'ar')
            المزيد من {{ $article->category->name_ar }}
            @else
                More from {{ $article->category->name ?? $article->category->name_ar }}
            @endif
        </a>
    </div>

    <!-- AI Chat Assistant -->
    <div class="fixed bottom-6 right-6 z-50">
        <!-- Chat Toggle Button -->
        <button id="ai-chat-toggle" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full p-4 shadow-2xl transition-all transform hover:scale-110 hover:shadow-blue-500/50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </button>

        <!-- Chat Window -->
        <div id="ai-chat-window" class="hidden fixed bottom-24 right-6 w-96 max-w-[calc(100vw-3rem)] bg-gray-900 border-2 border-blue-500 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <h3 class="text-white font-bold">{{ app()->getLocale() === 'ar' ? 'مساعد AI' : 'AI Assistant' }}</h3>
                </div>
                <button id="close-chat" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Quick Actions -->
            <div class="p-3 bg-gray-800 border-b border-gray-700">
                <div class="flex gap-2 flex-wrap">
                    <button class="quick-action-btn text-xs px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-full transition-all" data-action="summarize">
                        {{ app()->getLocale() === 'ar' ? '📝 لخص المقال' : '📝 Summarize' }}
                    </button>
                    <button class="quick-action-btn text-xs px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-full transition-all" data-action="key-points">
                        {{ app()->getLocale() === 'ar' ? '🎯 النقاط الرئيسية' : '🎯 Key Points' }}
                    </button>
                    <button class="quick-action-btn text-xs px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-full transition-all" data-action="explain">
                        {{ app()->getLocale() === 'ar' ? '💡 اشرح بشكل مبسط' : '💡 Explain Simply' }}
                    </button>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chat-messages" class="h-96 overflow-y-auto p-4 space-y-3 bg-gray-950">
                <div class="flex items-start gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-bold">AI</span>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-3 max-w-[80%]">
                        <p class="text-gray-300 text-sm {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            {{ app()->getLocale() === 'ar' ? 'مرحباً! أنا هنا لمساعدتك في فهم هذا المقال. اسألني أي سؤال!' : 'Hello! I\'m here to help you understand this article. Ask me anything!' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="p-3 bg-gray-900 border-t border-gray-700">
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        id="chat-input" 
                        placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب سؤالك هنا...' : 'Ask a question...' }}" 
                        class="flex-1 bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
                    >
                    <button 
                        id="send-message" 
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Table of Contents CSS -->
<link rel="stylesheet" href="{{ asset('css/article-toc.css') }}">

<!-- Article Content CSS -->
<link rel="stylesheet" href="{{ asset('css/article-content.css') }}">

<!-- AI Chat Animation Styles -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>
@endpush

@push('scripts')
<!-- Table of Contents JavaScript -->
<script src="{{ asset('js/article-toc.js') }}"></script>

<!-- AI Chat JavaScript -->
<script src="{{ asset('js/article-ai-chat.js') }}"></script>

<script>
    function copyCode(button) {
        const preElement = button.nextElementSibling; // Get the <pre> element
        const codeElement = preElement.querySelector('code');
        const codeToCopy = codeElement.innerText;

        navigator.clipboard.writeText(codeToCopy).then(() => {
            button.innerText = '{{ app()->getLocale() === 'ar' ? 'تم النسخ!' : 'Copied!' }}';
            setTimeout(() => {
                button.innerText = '{{ app()->getLocale() === 'ar' ? 'نسخ' : 'Copy' }}';
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
            button.innerText = '{{ app()->getLocale() === 'ar' ? 'فشل النسخ' : 'Failed' }}';
             setTimeout(() => {
                button.innerText = '{{ app()->getLocale() === 'ar' ? 'نسخ' : 'Copy' }}';
            }, 2000);
        });
    }
</script>
@endpush 
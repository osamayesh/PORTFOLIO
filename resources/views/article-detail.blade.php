@extends('layouts.app')

@section('title', $article->title . ' - Osama Ayesh')

@section('content')
<div class="container mx-auto max-w-4xl py-16">
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

    <!-- Article Content -->
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
</div>
@endsection

@push('styles')
<style>
    .rtl {
        direction: rtl;
        text-align: right;
    }
    
    .ltr {
        direction: ltr;
        text-align: left;
    }
    
    .prose.rtl {
        direction: rtl;
        text-align: right;
    }
    
    .prose.ltr {
        direction: ltr;
        text-align: left;
    }
    
    .prose p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    /* Article Content Formatting - Simple and Reliable */
    .article-content {
        white-space: pre-line; /* Preserves line breaks */
        word-wrap: break-word;
        font-size: 1.125rem;
        line-height: 1.7;
        font-weight: 500; /* Improved from 400 for better readability */
    }

    

    .article-content h1 { font-size: 2rem; }
    .article-content h2 { font-size: 1.75rem; }
    .article-content h3 { font-size: 1.5rem; }
    .article-content h4 { font-size: 1.25rem; }

    .article-content p {
        margin-bottom: 1rem;
        line-height: 1.7;
        font-weight: 500; /* Consistent weight */
    }

    .article-content ul, .article-content ol {
        margin: 1rem 0;
        padding-left: 2rem;
        font-weight: 500; /* Consistent weight */
    }

    .article-content ul {
        list-style-type: disc;
    }

    .article-content ol {
        list-style-type: decimal;
    }

    .article-content li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
        font-weight: 500; /* Consistent weight */
    }

    /* Enhanced emphasis with multiple visual cues */
    .article-content strong {
        color: #fbbf24; /* yellow-400 */
        font-weight: 600;
        background-color: rgba(251, 191, 36, 0.1); /* Light background highlight */
        padding: 0.1rem 0.2rem;
        border-radius: 0.125rem;
    }

    .article-content em {
        color: #a78bfa; /* violet-400 */
        font-style: italic;
        background-color: rgba(167, 139, 250, 0.1); /* Light background highlight */
        padding: 0.1rem 0.2rem;
        border-radius: 0.125rem;
    }

    .article-content code:not(pre code) {
        background-color: #374151; /* gray-700 */
        color: #fbbf24; /* yellow-400 */
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
        font-weight: 500;
        border: 1px solid rgba(251, 191, 36, 0.2); /* Subtle border for better definition */
    }

    .article-content a {
        color: #60a5fa; /* blue-400 */
        text-decoration: none;
        transition: color 0.3s ease;
        font-weight: 500;
        background-color: rgba(96, 165, 250, 0.1); /* Light background highlight */
        padding: 0.1rem 0.2rem;
        border-radius: 0.125rem;
    }

    .article-content a:hover {
        color: #93c5fd; /* blue-300 */
        background-color: rgba(96, 165, 250, 0.2);
        text-decoration: underline;
    }

    .article-content blockquote {
        border-left: 4px solid #3b82f6; /* blue-500 */
        background-color: rgba(59, 130, 246, 0.15); /* Slightly brighter background */
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0.5rem;
        color: #e5e7eb;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1); /* Light box-shadow */
    }

    /* RTL specific styles */
    .article-content.rtl ul, .article-content.rtl ol {
        padding-right: 2rem;
        padding-left: 0;
    }

    .article-content.rtl blockquote {
        border-left: none;
        border-right: 4px solid #3b82f6;
    }

    /* Special styling for technical terms and key concepts */
    .article-content .highlight-term {
        color: #34d399; /* emerald-400 */
        background-color: rgba(52, 211, 153, 0.1);
        padding: 0.1rem 0.3rem;
        border-radius: 0.25rem;
        border-bottom: 2px dotted #34d399;
        font-weight: 600;
        cursor: help;
    }

    /* Improved focus states for accessibility */
    .article-content a:focus,
    .article-content strong:focus,
    .article-content em:focus {
        outline: 2px solid #60a5fa;
        outline-offset: 2px;
        box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
    }

    /* Better list styling with consistent bullet points */
    .article-content ul li::marker {
        color: #60a5fa;
        font-weight: bold;
    }

    .article-content ol li::marker {
        color: #60a5fa;
        font-weight: bold;
    }

    /* Fallback for older browsers - add bullet symbols */
    .article-content ul li:before {
        content: "•";
        color: #60a5fa;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
        font-size: 1.2em;
        line-height: 1;
    }

    /* Code Snippet Styles */
    .code-snippet-container {
        position: relative;
        background-color: #1a202c; /* Dark background like the image */
        border-radius: 0.5rem;
        padding: 1.5rem; /* Equivalent to p-6 */
        overflow: hidden; /* Ensures the button doesn't overflow weirdly with line numbers */
    }

    .code-snippet-container pre[class*="language-"] {
        background-color: transparent !important; /* Override Prism default if any */
        padding: 0 !important; /* Reset padding as container handles it */
        margin: 0 !important; /* Reset margin */
        border-radius: 0; /* Reset border-radius */
        font-size: 0.875rem; /* text-sm */
        line-height: 1.6;
        color: #e2e8f0; /* Light text color */
        white-space: pre-wrap;       /* Since CSS 2.1 */
        white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
        white-space: -pre-wrap;      /* Opera 4-6 */
        white-space: -o-pre-wrap;    /* Opera 7 */
        word-wrap: break-word;       /* Internet Explorer 5.5+ */
    }

    .code-snippet-container pre[class*="language-"] code {
        font-family: 'Fira Code', 'Consolas', 'Monaco', 'Andale Mono', 'Ubuntu Mono', monospace;
        color: #e2e8f0; /* Light text color */
    }

    .copy-button {
        position: absolute;
        top: 0.75rem; /* Adjust as needed */
        right: 0.75rem; /* Adjust as needed */
        background-color: #4a5568; /* gray-700 */
        color: white;
        padding: 0.25rem 0.5rem; /* px-2 py-1 */
        font-size: 0.75rem; /* text-xs */
        border-radius: 0.25rem; /* rounded */
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .code-snippet-container:hover .copy-button {
        opacity: 1;
    }
    
    /* Prism.js line numbers adjustments if you use them */
    .line-numbers .line-numbers-rows {
        border-right: 1px solid #4a5568; /* A bit darker border for line numbers */
        padding-top: 1.5rem !important; /* Align with container padding */
        padding-bottom: 1.5rem !important; /* Align with container padding */
    }
    .line-numbers-rows > span:before {
        color: #718096; /* gray-500 */
    }

    /* Enhanced article container with brighter background and shadow */
    .article-container {
        background-color: rgba(17, 24, 39, 0.75) !important; /* 5% brighter than bg-gray-900 */
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.08); /* Light blue box-shadow */
        border: 1px solid rgba(59, 130, 246, 0.1); /* Subtle border */
    }
    
    .description-container {
        background-color: rgba(59, 130, 246, 0.15) !important; /* 5% brighter */
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
    }
    
    .prose.rtl {
        direction: rtl;
        text-align: right;
    }

    /* Comparison Table Styles */
    .comparison-table-container {
        margin: 1.5rem 0;
        border: 1px solid rgba(59, 130, 246, 0.2);
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.1);
    }

    .comparison-table {
        border-collapse: collapse;
        width: 100%;
        font-size: 0.9rem;
    }

    .comparison-table.table-default th {
        background-color: #374151;
        padding: 0.75rem 1rem;
        border-bottom: 2px solid #4b5563;
    }

    .comparison-table.table-default td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #374151;
    }

    .comparison-table.table-compact th {
        padding: 0.5rem 0.75rem;
        background-color: #374151;
        border-bottom: 1px solid #4b5563;
    }

    .comparison-table.table-compact td {
        padding: 0.5rem 0.75rem;
        border-bottom: 1px solid #374151;
    }

    .comparison-table.table-modern th {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        padding: 1rem;
        border: none;
        color: white;
        font-weight: 600;
    }

    .comparison-table.table-modern td {
        padding: 1rem;
        border: none;
        border-bottom: 1px solid #374151;
    }

    .comparison-table.table-striped tbody tr:nth-child(even) {
        background-color: #1f2937;
    }

    .comparison-table.table-striped tbody tr:nth-child(odd) {
        background-color: #111827;
    }

    .comparison-table th,
    .comparison-table td {
        text-align: left;
        vertical-align: top;
    }

    .comparison-table.rtl th,
    .comparison-table.rtl td {
        text-align: right;
    }

    .comparison-table tbody tr:hover {
        background-color: #374151 !important;
    }

    /* Responsive table scroll */
    .comparison-table-container .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #4b5563 #1f2937;
    }

    .comparison-table-container .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .comparison-table-container .overflow-x-auto::-webkit-scrollbar-track {
        background: #1f2937;
    }

    .comparison-table-container .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 4px;
    }

    .comparison-table-container .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }
</style>
@endpush

@push('scripts')
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
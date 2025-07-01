@extends('layouts.app')

@section('title', 'PDF Viewer - Portfolio - Osama Ayesh')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Simple PDF Viewer with Fullscreen Support -->
    <div class="bg-gray-800 rounded-lg border border-gray-600 shadow-2xl pdf-container">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-600 bg-gray-700">
            <h3 class="text-xl font-semibold text-white truncate mr-4">
                {{ $title ?? 'PDF Document' }}
            </h3>
            <div class="flex items-center space-x-2">
                <!-- Fullscreen Button -->
                <button onclick="toggleFullscreen()" class="text-gray-300 hover:text-white p-2 bg-gray-800 rounded-lg" title="Toggle Fullscreen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                </button>
                <!-- Download Button -->
                @if(isset($downloadUrl))
                <a href="{{ $downloadUrl }}" class="text-gray-300 hover:text-white p-2 bg-gray-800 rounded-lg" title="Download PDF">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </a>
                @endif
                <!-- Back Button -->
                <a href="{{ url()->previous() }}" class="text-gray-400 hover:text-white p-2" title="Go Back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- PDF Content -->
        <div class="bg-white rounded-b-lg" style="height: calc(100vh - 200px); min-height: 600px;">
            @if(isset($pdfUrl))
                <iframe 
                    src="{{ $pdfUrl }}" 
                    class="w-full h-full rounded-b-lg"
                    frameborder="0"
                    title="PDF Viewer">
                    <p class="p-4 text-center text-gray-600">
                        Your browser does not support PDFs. 
                        <a href="{{ $pdfUrl }}" class="text-blue-600 hover:underline">Download the PDF</a> instead.
                    </p>
                </iframe>
            @else
                <div class="flex items-center justify-center h-full">
                    <div class="text-center text-gray-600">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold mb-2">No PDF Available</h3>
                        <p>The PDF file could not be loaded.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Instructions -->
    <div class="mt-6 bg-gray-800/50 rounded-lg p-4 border border-gray-700">
        <h4 class="text-lg font-semibold text-white mb-2">PDF Viewer Instructions</h4>
        <ul class="text-gray-300 space-y-1">
            <li>• Use your browser's built-in PDF controls for navigation</li>
            <li>• Right-click on the PDF to access zoom and print options</li>
            <li>• Use Ctrl+F (Cmd+F on Mac) to search within the PDF</li>
            <li>• This viewer works without JavaScript for better compatibility</li>
        </ul>
    </div>
</div>

<style>
/* Ensure PDF iframe is responsive */
iframe {
    border: none;
    background: #ffffff;
}

/* Fullscreen styles */
.pdf-container {
    transition: all 0.3s ease;
}

.pdf-container.fullscreen {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 9999 !important;
    background: #1f2937 !important;
    margin: 0 !important;
    padding: 0 !important;
    border-radius: 0 !important;
    border: none !important;
}

.pdf-container.fullscreen .bg-gray-700 {
    border-radius: 0 !important;
    height: 60px !important;
}

.pdf-container.fullscreen .bg-white {
    border-radius: 0 !important;
    height: calc(100vh - 60px) !important;
    min-height: calc(100vh - 60px) !important;
}

.pdf-container.fullscreen iframe {
    width: 100% !important;
    height: 100% !important;
    min-height: calc(100vh - 60px) !important;
    border-radius: 0 !important;
}

/* Hide website header and other content in fullscreen */
body.fullscreen-active {
    overflow: hidden;
}

body.fullscreen-active > *:not(.pdf-container) {
    display: none !important;
}

body.fullscreen-active .pdf-container {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 9999 !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Print styles */
@media print {
    .container {
        max-width: none !important;
        padding: 0 !important;
    }
    
    .bg-gray-800, .bg-gray-700 {
        background: white !important;
        color: black !important;
    }
    
    .border-gray-600, .border-gray-700 {
        border-color: #ccc !important;
    }
}
</style>

<script>
let isFullscreen = false;

function toggleFullscreen() {
    const pdfContainer = document.querySelector('.pdf-container');
    const body = document.body;
    
    console.log('Toggling fullscreen, current state:', isFullscreen);
    
    if (!isFullscreen) {
        // Enter fullscreen
        pdfContainer.classList.add('fullscreen');
        body.classList.add('fullscreen-active');
        
        // Move PDF container to body to escape parent constraints
        body.appendChild(pdfContainer);
        
        isFullscreen = true;
        console.log('Entered fullscreen mode');
    } else {
        // Exit fullscreen
        pdfContainer.classList.remove('fullscreen');
        body.classList.remove('fullscreen-active');
        
        // Move PDF container back to original parent
        const originalParent = document.querySelector('.container');
        originalParent.appendChild(pdfContainer);
        
        isFullscreen = false;
        console.log('Exited fullscreen mode');
    }
}

// ESC key to exit fullscreen
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && isFullscreen) {
        e.preventDefault();
        toggleFullscreen();
    }
});

// F key to toggle fullscreen
document.addEventListener('keydown', function(e) {
    if (e.key === 'f' || e.key === 'F') {
        e.preventDefault();
        toggleFullscreen();
    }
});

// Debug: Log when script loads
console.log('PDF viewer fullscreen script loaded');
</script>
@endsection 
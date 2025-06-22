@extends('layouts.app')

@section('title', 'Portfolio - Osama Ayesh')

@section('content')
<div class="container mx-auto max-w-4xl text-center py-12 md:py-20 px-4">
    
    
    <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold mb-4">{{ __('welcome.greeting') }}</h1>
    
    <div class="text-lg md:text-xl lg:text-3xl font-bold mb-6 md:mb-8">
        <div class="technologies-container">
            <div class="technologies-slider">
                <div class="technology-item">
                    <span class="typewriter texture-text">{{ __('welcome.profession.dotnet') }}</span>
                </div>
                <div class="technology-item">
                    <span class="typewriter texture-text">{{ __('welcome.profession.devops') }}</span>
                </div>
                <div class="technology-item">
                    <span class="typewriter texture-text">{{ __('welcome.profession.sql') }}</span>
                </div>
                <div class="technology-item">
                    <span class="typewriter texture-text">{{ __('welcome.profession.laravel') }}</span>
                </div>
                <div class="technology-item">
                    <span class="typewriter texture-text">{{ __('welcome.profession.aws') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <p class="text-base md:text-lg lg:text-xl text-gray-300 max-w-2xl mx-auto mb-8 md:mb-12 px-4">
        {{ __('welcome.description') }}
    </p>
    
    <a href="{{ route('cv.download') }}" class="inline-block px-6 md:px-8 py-2 md:py-3 bg-transparent border-2 border-blue-500 text-blue-400 rounded-md 
                     font-medium hover:bg-blue-900 hover:bg-opacity-30 transition-all duration-300
                     shadow-lg shadow-blue-500/30 text-sm md:text-base">
        {{ __('welcome.download_resume') }}
    </a>
</div>
@endsection

@push('styles')
<style>
    @keyframes textureShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    
    .texture-text {
        background-image: linear-gradient(
            45deg, 
            #ffd700 0%, 
            #f5d742 20%, 
            #f59f42 40%, 
            #ffce44 60%, 
            #ffd700 80%, 
            #f5d742 100%
        );
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        animation: textureShift 3s linear infinite;
        display: inline-block;
        text-shadow: 0 0 8px rgba(255,215,0,0.1);
        position: relative;
    }
    
    /* Typewriter effect containers */
    .typewriter-container {
        display: inline-block;
        margin: 0 auto;
    }
    
    /* The typing and erasing effect */
    @keyframes typing-erasing {
        0%, 100% { width: 0 }
        20% { width: 100% }
        80% { width: 100% }
        95% { width: 0 }
    }
    
    /* The typewriter cursor effect */
    @keyframes blink-caret {
        from, to { border-color: transparent }
        50% { border-color: gold }
    }
    
    .typewriter {
        overflow: hidden;
        white-space: nowrap;
        margin: 0 auto;
        border-right: 3px solid gold;
        width: 0;
        animation: typing-erasing 4s steps(40, end) infinite;
    }
    
    /* Simplified cycle animation */
    @keyframes technologies-cycle {
        0%, 19% { transform: translateY(0); }
        20%, 39% { transform: translateY(-30px); }
        40%, 59% { transform: translateY(-60px); }
        60%, 79% { transform: translateY(-90px); }
        80%, 99% { transform: translateY(-120px); }
        100% { transform: translateY(0); }
    }
    
    .technologies-container {
        position: relative;
        height: 30px;
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .technologies-slider {
        position: relative;
        height: 150px;
        animation: technologies-cycle 20s infinite;
    }
    
    .technology-item {
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Mobile responsive adjustments */
    @media (min-width: 768px) {
        .technologies-container {
            height: 40px;
            margin-bottom: 40px;
        }
        
        .technologies-slider {
            height: 200px;
        }
        
        .technology-item {
            height: 40px;
        }
        
        @keyframes technologies-cycle {
            0%, 19% { transform: translateY(0); }
            20%, 39% { transform: translateY(-40px); }
            40%, 59% { transform: translateY(-80px); }
            60%, 79% { transform: translateY(-120px); }
            80%, 99% { transform: translateY(-160px); }
            100% { transform: translateY(0); }
        }
    }
    
    /* For additional words that appear after typing */
    .delayed-appear {
        opacity: 0;
        animation: fadeIn 1s forwards;
        animation-delay: 3.5s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Add a subtle pulsing glow effect */
    .texture-text::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,215,0,0.2) 0%, transparent 70%);
        opacity: 0;
        animation: pulse 2s ease-in-out infinite;
        z-index: -1;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 0; }
        50% { opacity: 1; }
    }
    
    /* Navigation hover effects */
    .nav-link {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 0;
        background: #0dd3ff;
        transition: all 0.3s ease;
        opacity: 0;
    }
    
    .nav-link:hover::after {
        width: 100%;
        opacity: 1;
    }
    
    .nav-link:hover {
        color: #ffffff;
    }
    
    .nav-link.active {
        color: #3bc9db;
    }
    
    .nav-link.active::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        bottom: -4px;
        left: 0;
        background: #0dd3ff;
        opacity: 1;
    }
    
    /* Mobile font size adjustments */
    @media (max-width: 480px) {
        .typewriter {
            font-size: 0.9rem;
        }
    }
</style>
@endpush

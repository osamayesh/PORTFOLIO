@extends('layouts.app')

@section('title', __('education.title') . ' - Osama Ayesh')

@section('content')
<div class="container mx-auto max-w-5xl py-16">
    <!-- Page Header -->
    <div class="text-center mb-16">
        <div class="flex items-center justify-center mb-8">
            <div class="w-32 h-1 bg-blue-500"></div>
            <h1 class="text-4xl md:text-5xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">🎓</span>
                <span>{{ __('education.page_title') }}</span>
            </h1>
            <div class="w-32 h-1 bg-blue-500"></div>
        </div>
    </div>

    <!-- Education Card -->
    <div class="bg-gray-900 bg-opacity-70 rounded-lg p-8 mb-16 border border-blue-900 hover:border-blue-500 transition-all duration-300">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
            <!-- University Logo/Icon -->
            <div class="flex-shrink-0">
                <div class="w-24 h-24 bg-blue-600 bg-opacity-20 rounded-full flex items-center justify-center border-2 border-blue-500">
                    <span class="text-4xl">🏛️</span>
                </div>
            </div>
            
            <!-- Education Details -->
            <div class="flex-grow text-center lg:text-right rtl">
                <div class="mb-4">
                    <h2 class="text-2xl md:text-3xl font-bold texture-text mb-2">{{ __('education.university') }}</h2>
                    <h3 class="text-xl md:text-2xl text-gray-300 mb-2">{{ __('education.degree') }}</h3>
                    <div class="flex items-center justify-center lg:justify-start gap-2 text-blue-400">
                        <span class="text-lg">📅</span>
                        <span class="text-lg font-medium">{{ __('education.duration') }}</span>
                    </div>
                </div>
                
                <p class="text-lg text-gray-300 leading-relaxed">
                    {{ __('education.description') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Subjects Section -->
    <div class="mb-16">
        <div class="flex items-center justify-center mb-12">
            <div class="w-32 h-1 bg-blue-500"></div>
            <h2 class="text-3xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">📚</span>
                <span>{{ __('education.subjects.title') }}</span>
            </h2>
            <div class="w-32 h-1 bg-blue-500"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">💻</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.programming') }}</h3>
            </div>
            
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">🔢</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.algorithms') }}</h3>
            </div>
            
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">🏗️</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.software_engineering') }}</h3>
            </div>
            
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">🗃️</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.databases') }}</h3>
            </div>
            
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">🌐</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.networks') }}</h3>
            </div>
            
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">⚙️</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.systems') }}</h3>
            </div>
            
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">🌍</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.web') }}</h3>
            </div>
            
            <!-- Subject Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl mb-3">📊</div>
                <h3 class="text-lg font-bold text-blue-300">{{ __('education.subjects.math') }}</h3>
            </div>
        </div>
    </div>

    <!-- Services section removed and moved to dedicated Services page -->

    <!-- Achievements Section -->
    <div class="mb-16">
        <div class="flex items-center justify-center mb-12">
            <div class="w-32 h-1 bg-blue-500"></div>
            <h2 class="text-3xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">🏆</span>
                <span>{{ __('education.achievements.title') }}</span>
            </h2>
            <div class="w-32 h-1 bg-blue-500"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Achievement Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-4xl mb-4">🎓</div>
                <p class="text-gray-300">{{ __('education.achievements.graduation') }}</p>
            </div>
            
            <!-- Achievement Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-4xl mb-4">💼</div>
                <p class="text-gray-300">{{ __('education.achievements.projects') }}</p>
            </div>
            
            <!-- Achievement Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-4xl mb-4">🚀</div>
                <p class="text-gray-300">{{ __('education.achievements.skills') }}</p>
            </div>
        </div>
    </div>

    

    <!-- Contact Section -->
    <div class="text-center">
        <a href="{{ url('about') }}" class="inline-block px-8 py-3 bg-transparent border-2 border-blue-500 text-blue-400 rounded-md 
                     font-medium hover:bg-blue-900 hover:bg-opacity-30 transition-all duration-300
                     shadow-lg shadow-blue-500/30">
            {{ __('education.more_about_me') }}
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rtl {
        direction: rtl;
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
</style>
@endpush

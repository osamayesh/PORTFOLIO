@extends('layouts.app')

@section('title', 'About - Osama Ayesh')

@section('content')
<div class="container mx-auto max-w-5xl py-16">
    <!-- Profile Section -->
    <div class="flex flex-col items-center mb-16">
        <div class="w-64 h-64 rounded-full overflow-hidden border-4 border-blue-500 mb-8 hover:border-blue-400 transition-all duration-300">
            <img src="{{ asset('images/odx.png') }}" alt="Osama Ayesh" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" onerror="this.src='https://via.placeholder.com/400?text=Osama+Ayesh'">
        </div>
        
        <div class="text-center">
            <div class="flex items-center justify-center mb-8">
                <div class="w-32 h-1 bg-blue-500"></div>
                <h1 class="text-4xl md:text-5xl font-bold mx-4 text-blue-400">
                    {{ __('about.title') }}
                </h1>
                <div class="w-32 h-1 bg-blue-500"></div>
            </div>
            
            <div class="text-2xl text-gray-300 mb-8">
                <span class="texture-text">{{ __('about.full_stack') }}</span>
                <span class="text-gray-400"> Software Engineer</span>
            </div>
        </div>
    </div>
    
    <!-- Biography Section -->
    <div class="bg-gray-900 bg-opacity-70 rounded-lg p-8 mb-16 border border-blue-900 hover:border-blue-500 transition-all duration-300">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Journey -->
            <div class="text-center {{ app()->getLocale() === 'ar' ? 'lg:text-right' : 'lg:text-left' }}">
                <h3 class="text-2xl font-bold text-blue-400 mb-4 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'lg:justify-start' : 'lg:justify-start' }}">
                    <span class="mx-2">🚀</span>
                    <span>{{ __('about.biography.journey') }}</span>
                </h3>
                <div class="space-y-4 text-lg text-gray-300 leading-relaxed">
                    <p>{{ __('about.biography.journey_start') }} 
                     <span class="texture-text">Full Stack Development</span></p>
                </div>
            </div>
            
            <!-- Experience -->
            <div class="text-center {{ app()->getLocale() === 'ar' ? 'lg:text-right' : 'lg:text-left' }}">
                <h3 class="text-2xl font-bold text-blue-400 mb-4 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'lg:justify-start' : 'lg:justify-start' }}">
                    <span class="mx-2">💼</span>
                    <span>{{ __('about.biography.experience') }}</span>
                </h3>
                <div class="space-y-4 text-lg text-gray-300 leading-relaxed">
                    <p>{{ __('about.biography.work_experience') }}</p>
                    <p>{{ __('about.biography.content_creation') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="text-center mb-16">
        <div class="flex justify-center items-center mb-8">
            <span class="text-red-500 text-2xl animate-bounce">▼</span>
            <span class="mx-4 text-xl text-gray-300 font-medium">{{ __('about.quick_links.read_here') }}</span>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-center gap-6 {{ app()->getLocale() === 'ar' ? 'sm:flex-row-reverse' : '' }}">
            <a href="{{ url('summaries') }}" class="flex items-center justify-center gap-3 px-8 py-6 bg-blue-600 bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all duration-300 border border-blue-500 hover:border-blue-400 hover:scale-105">
                <span class="text-yellow-400 text-3xl">📁</span>
                <span class="text-xl font-semibold">{{ __('about.quick_links.summaries') }}</span>
            </a>
            
            <a href="{{ url('articles') }}" class="flex items-center justify-center gap-3 px-8 py-6 bg-blue-600 bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all duration-300 border border-blue-500 hover:border-blue-400 hover:scale-105">
                <span class="text-orange-400 text-3xl">📝</span>
                <span class="text-xl font-semibold">{{ __('about.quick_links.articles') }}</span>
            </a>
        </div>
    </div>
    
    <!-- Skills Section -->
    <div class="mb-16">
        <div class="flex items-center justify-center mb-12">
            <div class="w-32 h-1 bg-blue-500"></div>
            <h2 class="text-3xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">🛠️</span>
                <span>{{ __('about.skills_title') }}</span>
            </h2>
            <div class="w-32 h-1 bg-blue-500"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Skill Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center hover:scale-105">
                <div class="text-5xl mb-4">💻</div>
                <h3 class="text-xl font-bold mb-3 texture-text">C#</h3>
                <div class="w-full bg-gray-700 rounded-full h-3 mt-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: 95%"></div>
                </div>
                <span class="text-sm text-gray-400 mt-2 block">95%</span>
            </div>
            
            <!-- Skill Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center hover:scale-105">
                <div class="text-5xl mb-4">🌐</div>
                <h3 class="text-xl font-bold mb-3 texture-text">.NET Core</h3>
                <div class="w-full bg-gray-700 rounded-full h-3 mt-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: 90%"></div>
                </div>
                <span class="text-sm text-gray-400 mt-2 block">90%</span>
            </div>
            
            <!-- Skill Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center hover:scale-105">
                <div class="text-5xl mb-4">🗃️</div>
                <h3 class="text-xl font-bold mb-3 texture-text">SQL Server</h3>
                <div class="w-full bg-gray-700 rounded-full h-3 mt-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: 85%"></div>
                </div>
                <span class="text-sm text-gray-400 mt-2 block">85%</span>
            </div>
            
            <!-- Skill Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center hover:scale-105">
                <div class="text-5xl mb-4">🐘</div>
                <h3 class="text-xl font-bold mb-3 texture-text">PHP</h3>
                <div class="w-full bg-gray-700 rounded-full h-3 mt-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: 80%"></div>
                </div>
                <span class="text-sm text-gray-400 mt-2 block">80%</span>
            </div>
            
            <!-- Skill Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center hover:scale-105">
                <div class="text-5xl mb-4">🚀</div>
                <h3 class="text-xl font-bold mb-3 texture-text">Laravel</h3>
                <div class="w-full bg-gray-700 rounded-full h-3 mt-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: 85%"></div>
                </div>
                <span class="text-sm text-gray-400 mt-2 block">85%</span>
            </div>
            
            <!-- Skill Item -->
            <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center hover:scale-105">
                <div class="text-5xl mb-4">☁️</div>
                <h3 class="text-xl font-bold mb-3 texture-text">AWS</h3>
                <div class="w-full bg-gray-700 rounded-full h-3 mt-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: 75%"></div>
                </div>
                <span class="text-sm text-gray-400 mt-2 block">75%</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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

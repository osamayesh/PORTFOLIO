@extends('layouts.app')

@section('title', __('services.title') . ' - Osama Ayesh')

@section('content')
<div class="container mx-auto max-w-5xl py-16">
    <!-- Page Header -->
    <div class="text-center mb-16">
        <div class="flex items-center justify-center mb-8">
            <div class="w-32 h-1 bg-blue-500"></div>
            <h1 class="text-4xl md:text-5xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">🛠️</span>
                <span>{{ __('services.title') }}</span>
            </h1>
            <div class="w-32 h-1 bg-blue-500"></div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Service Item -->
        <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
            <div class="text-4xl mb-4">🌐</div>
            <h3 class="text-xl font-bold mb-2 texture-text">{{ __('services.web_development') }}</h3>
            <p class="text-gray-300">Building modern, responsive web applications with the latest technologies and best practices.</p>
        </div>
        
        <!-- Service Item -->
        <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
            <div class="text-4xl mb-4">🔌</div>
            <h3 class="text-xl font-bold mb-2 texture-text">{{ __('services.api_development') }}</h3>
            <p class="text-gray-300">Creating robust APIs and integrating third-party services to enhance application functionality.</p>
        </div>
        
        <!-- Service Item -->
        <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
            <div class="text-4xl mb-4">🗃️</div>
            <h3 class="text-xl font-bold mb-2 texture-text">{{ __('services.database_design') }}</h3>
            <p class="text-gray-300">Designing efficient database structures and optimizing queries for better performance.</p>
        </div>
        
        <!-- Service Item -->
        <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
            <div class="text-4xl mb-4">☁️</div>
            <h3 class="text-xl font-bold mb-2 texture-text">{{ __('services.cloud_solutions') }}</h3>
            <p class="text-gray-300">Implementing cloud-based solutions and managing application deployment on cloud platforms.</p>
        </div>
        
        <!-- Service Item -->
        <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
            <div class="text-4xl mb-4">🚀</div>
            <h3 class="text-xl font-bold mb-2 texture-text">{{ __('services.devops') }}</h3>
            <p class="text-gray-300">Setting up continuous integration and deployment pipelines for efficient software delivery.</p>
        </div>
        
        <!-- Service Item -->
        <div class="bg-gray-900 bg-opacity-70 p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
            <div class="text-4xl mb-4">💡</div>
            <h3 class="text-xl font-bold mb-2 texture-text">{{ __('services.consulting') }}</h3>
            <p class="text-gray-300">Providing expert technical advice and solutions for software development challenges.</p>
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
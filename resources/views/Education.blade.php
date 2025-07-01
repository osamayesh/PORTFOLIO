@extends('layouts.app')

@section('title', __('education.title') . ' - Osama Ayesh')

@section('content')
<div class="container mx-auto max-w-5xl py-8 md:py-16 px-4">
    <!-- Page Header -->
    <div class="text-center mb-12 md:mb-16">
        <div class="flex items-center justify-center mb-6 md:mb-8">
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">🎓</span>
                <span>{{ __('education.page_title') }}</span>
            </h1>
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
        </div>
    </div>

    <!-- Education Card -->
    <div class="bg-gray-900 bg-opacity-70 rounded-lg p-4 md:p-8 mb-12 md:mb-16 border border-blue-900 hover:border-blue-500 transition-all duration-300">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-6 md:gap-8">
            <!-- University Logo/Icon -->
            <div class="flex-shrink-0">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-blue-600 bg-opacity-20 rounded-full flex items-center justify-center border-2 border-blue-500">
                    <span class="text-3xl md:text-4xl">🏛️</span>
                </div>
            </div>
            
            <!-- Education Details -->
            <div class="flex-grow text-center {{ app()->getLocale() === 'ar' ? 'lg:text-right' : 'lg:text-left' }}">
                <div class="mb-4">
                    <h2 class="text-xl md:text-2xl lg:text-3xl font-bold texture-text mb-2">{{ __('education.university') }}</h2>
                    <h3 class="text-lg md:text-xl lg:text-2xl text-gray-300 mb-2">{{ __('education.degree') }}</h3>
                    <div class="flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'lg:justify-start' : 'lg:justify-start' }} gap-2 text-blue-400">
                        <span class="text-base md:text-lg">📅</span>
                        <span class="text-base md:text-lg font-medium">{{ __('education.duration') }}</span>
                    </div>
                </div>
                
                <p class="text-sm md:text-lg text-gray-300 leading-relaxed">
                    {{ __('education.description') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Internships Section -->
    <div class="mb-12 md:mb-16">
        <div class="flex items-center justify-center mb-8 md:mb-12">
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
            <h2 class="text-2xl md:text-3xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">💼</span>
                <span>{{ __('education.internships.title') }}</span>
            </h2>
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
            <!-- Internship Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300">
                <div class="flex items-start gap-3 md:gap-4">
                    <div class="text-2xl md:text-3xl">🏢</div>
                    <div class="flex-grow">
                        <h3 class="text-lg md:text-xl font-bold text-blue-300 mb-2">{{ __('education.internships.company_1') }}</h3>
                        <p class="text-sm md:text-base text-gray-300 mb-2">{{ __('education.internships.position_1') }}</p>
                        <p class="text-xs md:text-sm text-blue-400">{{ __('education.internships.duration_1') }}</p>
                        <p class="text-xs md:text-sm text-gray-400 mt-2">{{ __('education.internships.description_1') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Internship Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300">
                <div class="flex items-start gap-3 md:gap-4">
                    <div class="text-2xl md:text-3xl">🚀</div>
                    <div class="flex-grow">
                        <h3 class="text-lg md:text-xl font-bold text-blue-300 mb-2">{{ __('education.internships.company_2') }}</h3>
                        <p class="text-sm md:text-base text-gray-300 mb-2">{{ __('education.internships.position_2') }}</p>
                        <p class="text-xs md:text-sm text-blue-400">{{ __('education.internships.duration_2') }}</p>
                        <p class="text-xs md:text-sm text-gray-400 mt-2">{{ __('education.internships.description_2') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Internship Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 md:col-span-2">
                <div class="flex items-start gap-3 md:gap-4">
                    <div class="text-2xl md:text-3xl">🎯</div>
                    <div class="flex-grow">
                        <h3 class="text-lg md:text-xl font-bold text-blue-300 mb-2">{{ __('education.internships.company_3') }}</h3>
                        <p class="text-sm md:text-base text-gray-300 mb-2">{{ __('education.internships.position_3') }}</p>
                        <p class="text-xs md:text-sm text-blue-400">{{ __('education.internships.duration_3') }}</p>
                        <p class="text-xs md:text-sm text-gray-400 mt-2">{{ __('education.internships.description_3') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificates Section -->
    <div class="mb-12 md:mb-16">
        <div class="flex items-center justify-center mb-8 md:mb-12">
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
            <h2 class="text-2xl md:text-3xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">📄</span>
                <span>{{ __('education.certificates.title') }}</span>
            </h2>
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Certificate Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-2xl md:text-3xl mb-3">🏆</div>
                <h3 class="text-base md:text-lg font-bold text-blue-300 mb-2">{{ __('education.certificates.cert_1') }}</h3>
                <p class="text-xs md:text-sm text-gray-400">{{ __('education.certificates.issuer_1') }}</p>
                <p class="text-xs text-blue-400 mt-2">{{ __('education.certificates.date_1') }}</p>
            </div>
            
            <!-- Certificate Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-2xl md:text-3xl mb-3">🎖️</div>
                <h3 class="text-base md:text-lg font-bold text-blue-300 mb-2">{{ __('education.certificates.cert_2') }}</h3>
                <p class="text-xs md:text-sm text-gray-400">{{ __('education.certificates.issuer_2') }}</p>
                <p class="text-xs text-blue-400 mt-2">{{ __('education.certificates.date_2') }}</p>
            </div>
        </div>
    </div>

    <!-- Achievements Section -->
    <div class="mb-12 md:mb-16">
        <div class="flex items-center justify-center mb-8 md:mb-12">
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
            <h2 class="text-2xl md:text-3xl font-bold mx-4 text-blue-400 flex items-center">
                <span class="mx-2">🏆</span>
                <span>{{ __('education.achievements.title') }}</span>
            </h2>
            <div class="w-16 md:w-32 h-1 bg-blue-500"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            <!-- Achievement Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl md:text-4xl mb-3 md:mb-4">🎓</div>
                <p class="text-sm md:text-base text-gray-300">{{ __('education.achievements.graduation') }}</p>
            </div>
            
            <!-- Achievement Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl md:text-4xl mb-3 md:mb-4">💼</div>
                <p class="text-sm md:text-base text-gray-300">{{ __('education.achievements.projects') }}</p>
            </div>
            
            <!-- Achievement Item -->
            <div class="bg-gray-900 bg-opacity-70 p-4 md:p-6 rounded-lg border border-blue-900 hover:border-blue-500 transition-all duration-300 text-center">
                <div class="text-3xl md:text-4xl mb-3 md:mb-4">🚀</div>
                <p class="text-sm md:text-base text-gray-300">{{ __('education.achievements.skills') }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="text-center">
        <a href="{{ url('about') }}" class="inline-block px-6 md:px-8 py-2 md:py-3 bg-transparent border-2 border-blue-500 text-blue-400 rounded-md 
                     font-medium hover:bg-blue-900 hover:bg-opacity-30 transition-all duration-300
                     shadow-lg shadow-blue-500/30 text-sm md:text-base">
            {{ __('education.more_about_me') }}
        </a>
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
    
    /* Mobile hover adjustments */
    @media (max-width: 768px) {
        .hover\:border-blue-500:hover {
            border-color: rgba(59, 130, 246, 0.7);
        }
    }
</style>
@endpush

@extends('layouts.app')

@section('title', __('projects.title') . ' - Osama Ayesh')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-2 text-center">{{ __('projects.title') }} <span class="texture-text">Projects</span></h1>
    <p class="text-gray-400 text-center mb-12">{{ __('projects.subtitle') }}</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- BOOK Store Project -->
        <div class="project-card-container">
            <div class="project-card">
                <div class="project-card-front">
                    <img src="{{ asset('images/book.png') }}" alt="Recipe Search App" class="w-full h-full object-cover rounded-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-lg"></div>
                    <div class="absolute bottom-0 p-4">
                        <h3 class="text-xl font-bold mb-1 text-white">{{ __('projects.bookstore_title') }}</h3>
                        <div class="flex flex-wrap gap-1 mb-1">
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">.net mvc </span>
                            <span class="px-2 py-0.5 bg-green-900 text-green-200 text-xs rounded">API</span>
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">SQL</span>
                        </div>
                        
                    </div>
                </div>
                <div class="project-card-back">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-white">{{ __('projects.bookstore_title') }}</h3>
                        <p class="text-sm text-gray-300 mb-3">
                            {{ __('projects.bookstore_desc') }}
                        </p>
                        <div class="flex flex-wrap gap-1 mb-3">
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">React</span>
                            <span class="px-2 py-0.5 bg-green-900 text-green-200 text-xs rounded">API Integration</span>
                            <span class="px-2 py-0.5 bg-purple-900 text-purple-200 text-xs rounded">Responsive</span>
                        </div>
                        <a href="https://github.com/osamayesh/Bookly" class="text-gray-400 hover:text-white transition flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            {{ __('projects.source_code') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- EMPLOYEE MANAGEMENT Project -->
        <div class="project-card-container">
            <div class="project-card">
                <div class="project-card-front">
                    <img src="{{ asset('images/employe.png') }}" alt="Weather App" class="w-full h-full object-cover rounded-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-lg"></div>
                    <div class="absolute bottom-0 p-4">
                        <h3 class="text-xl font-bold mb-1 text-white">{{ __('projects.employee_title') }}</h3>
                        <div class="flex flex-wrap gap-1 mb-1">
                            <span class="px-2 py-0.5 bg-yellow-900 text-yellow-200 text-xs rounded">asp.net form</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">sql server</span>
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">c#</span>
                        </div>
                        
                    </div>
                </div>
                <div class="project-card-back">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-white">{{ __('projects.employee_title') }}</h3>
                        <p class="text-sm text-gray-300 mb-3">
                            {{ __('projects.employee_desc') }}
                        </p>
                        <div class="flex flex-wrap gap-1 mb-3">
                        <span class="px-2 py-0.5 bg-yellow-900 text-yellow-200 text-xs rounded">asp.net form</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">sql server</span>
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">c#</span>
                        </div>
                        <a href="https://github.com/osamayesh/curdEmpForm" class="text-gray-400 hover:text-white transition flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            {{ __('projects.source_code') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Student Portal Project -->
        <div class="project-card-container">
            <div class="project-card">
                <div class="project-card-front">
                    <img src="{{ asset('images/student.png') }}" alt="Student Dashboard" class="w-full h-full object-cover rounded-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-lg"></div>
                    <div class="absolute bottom-0 p-4">
                        <h3 class="text-xl font-bold mb-1 text-white">{{ __('projects.student_title') }}</h3>
                        <div class="flex flex-wrap gap-1 mb-1">
                            <span class="px-2 py-0.5 bg-indigo-900 text-indigo-200 text-xs rounded">Laravel</span>
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">MySQL</span>
                        </div>
                      
                    </div>
                </div>
                <div class="project-card-back">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-white">{{ __('projects.student_title') }}</h3>
                        <p class="text-sm text-gray-300 mb-3">
                            {{ __('projects.student_desc') }}
                        </p>
                        <div class="flex flex-wrap gap-1 mb-3">
                            <span class="px-2 py-0.5 bg-indigo-900 text-indigo-200 text-xs rounded">Laravel</span>
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">MySQL</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">Bootstrap</span>
                        </div>
                        <a href="https://github.com/osamayesh/StudentDashboard" class="text-gray-400 hover:text-white transition flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            {{ __('projects.source_code') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Portfolio Website Project -->
        <div class="project-card-container">
            <div class="project-card">
                <div class="project-card-front">
                    <img src="{{ asset('images/portfolio.png') }}" alt="Portfolio Website" class="w-full h-full object-cover rounded-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-lg"></div>
                    <div class="absolute bottom-0 p-4">
                        <h3 class="text-xl font-bold mb-1 text-white">{{ __('projects.portfolio_title') }}</h3>
                        <div class="flex flex-wrap gap-1 mb-1">
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">Laravel</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">Tailwind</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">MySQL</span>
                        </div>
                       
                    </div>
                </div>
                <div class="project-card-back">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-white">{{ __('projects.portfolio_title') }}</h3>
                        <p class="text-sm text-gray-300 mb-3">
                            {{ __('projects.portfolio_desc') }}
                        </p>
                        <div class="flex flex-wrap gap-1 mb-3">
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">Laravel</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">Tailwind CSS</span>
                            <span class="px-2 py-0.5 bg-yellow-900 text-yellow-200 text-xs rounded">JavaScript</span>
                        </div>
                        <a href="#" class="text-gray-400 hover:text-white transition flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            {{ __('projects.source_code') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Smart Contact Manager Project -->
        <div class="project-card-container">
            <div class="project-card">
                <div class="project-card-front">
                    <img src="{{ asset('images/contact.png') }}" alt="E-commerce Site" class="w-full h-full object-cover rounded-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-lg"></div>
                    <div class="absolute bottom-0 p-4">
                        <h3 class="text-xl font-bold mb-1 text-white">{{ __('projects.contact_title') }}</h3>
                        <div class="flex flex-wrap gap-1 mb-1">
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">blazor web assembly</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">local storage</span>
                        </div>
                        
                    </div>
                </div>
                <div class="project-card-back">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-white">{{ __('projects.contact_title') }}</h3>
                        <p class="text-sm text-gray-300 mb-3">
                            {{ __('projects.contact_desc') }}
                        </p>
                        <div class="flex flex-wrap gap-1 mb-3">
                            <span class="px-2 py-0.5 bg-red-900 text-red-200 text-xs rounded">PHP</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">MySQL</span>
                            <span class="px-2 py-0.5 bg-yellow-900 text-yellow-200 text-xs rounded">jQuery</span>
                        </div>
                        <a href="https://github.com/osamayesh/curdEmpForm" class="text-gray-400 hover:text-white transition flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            {{ __('projects.source_code') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- api  Project -->
        <div class="project-card-container">
            <div class="project-card">
                <div class="project-card-front">
                    <img src="{{ asset('images/OTP.png') }}" alt="Blog Platform" class="w-full h-full object-cover rounded-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-lg"></div>
                    <div class="absolute bottom-0 p-4">
                        <h3 class="text-xl font-bold mb-1 text-white">{{ __('projects.api_title') }}</h3>
                        <div class="flex flex-wrap gap-1 mb-1">
                            <span class="px-2 py-0.5 bg-indigo-900 text-indigo-200 text-xs rounded">Laravel</span>
                            <span class="px-2 py-0.5 bg-green-900 text-green-200 text-xs rounded">Vue.js</span>
                        </div>
                        
                    </div>
                </div>
                <div class="project-card-back">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-white">{{ __('projects.api_title') }}</h3>
                        <p class="text-sm text-gray-300 mb-3">
                            {{ __('projects.api_desc') }}
                        </p>
                        <div class="flex flex-wrap gap-1 mb-3">
                            <span class="px-2 py-0.5 bg-indigo-900 text-indigo-200 text-xs rounded">Laravel</span>
                            <span class="px-2 py-0.5 bg-green-900 text-green-200 text-xs rounded">Api</span>
                            <span class="px-2 py-0.5 bg-blue-900 text-blue-200 text-xs rounded">Tailwind</span>
                        </div>
                        <a href="https://github.com/osamayesh/OTP-Migration" class="text-gray-400 hover:text-white transition flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            {{ __('projects.source_code') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Card flip effect */
    .project-card-container {
        perspective: 1000px;
        height: 300px;
    }
    
    .project-card {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.8s;
        transform-style: preserve-3d;
        cursor: pointer;
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }
    
    .project-card-container:hover .project-card {
        transform: rotateY(180deg);
    }
    
    .project-card-front, .project-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .project-card-front {
        background-color: #1a202c;
    }
    
    .project-card-back {
        background: linear-gradient(135deg, rgba(26, 32, 44, 0.9), rgba(45, 55, 72, 0.9));
        transform: rotateY(180deg);
        display: flex;
        flex-direction: column;
    }
    
    /* Pulsing border effect */
    .project-card-container {
        padding: 2px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.7), rgba(147, 51, 234, 0.7));
        border-radius: 0.5rem;
        animation: borderPulse 4s infinite;
    }
    
    .project-card-container:nth-child(1) {
        animation-delay: 0s;
    }
    
    .project-card-container:nth-child(2) {
        animation-delay: 0.6s;
    }
    
    .project-card-container:nth-child(3) {
        animation-delay: 1.2s;
    }
    
    .project-card-container:nth-child(4) {
        animation-delay: 1.8s;
    }
    
    .project-card-container:nth-child(5) {
        animation-delay: 2.4s;
    }
    
    .project-card-container:nth-child(6) {
        animation-delay: 3s;
    }
    
    @keyframes borderPulse {
        0% { opacity: 0.7; }
        50% { opacity: 0.3; }
        100% { opacity: 0.7; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.project-card-container');
        
        cards.forEach(card => {
            card.addEventListener('touchstart', function() {
                const projectCard = this.querySelector('.project-card');
                projectCard.style.transform = projectCard.style.transform === 'rotateY(180deg)' ? 'rotateY(0deg)' : 'rotateY(180deg)';
            });
        });
    });
</script>
@endsection 
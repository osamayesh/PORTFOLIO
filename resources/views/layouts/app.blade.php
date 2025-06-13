<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" {{ app()->getLocale() === 'ar' ? 'class="rtl"' : '' }}>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Portfolio - Osama Ayesh')</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Prism.js CSS (Okaidia Theme and Line Numbers) -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />

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
              /* New styles for the top header */
              .rtl {
                direction: rtl;
                text-align: right;
            }
            
            .rtl .nav-link::after {
                left: auto;
                right: 0;
            }
            
            .rtl .language-switcher {
                direction: ltr; /* Keep language switcher in LTR */
                display: flex;
            }
            
            /* Additional RTL improvements */
            .rtl .flex {
                direction: rtl;
            }
            
            .rtl .flex-col {
                direction: ltr; /* Keep vertical layouts normal */
            }
            
            .rtl .text-center {
                text-align: center;
            }
            
            .rtl .text-left {
                text-align: right;
            }
            
            .rtl .text-right {
                text-align: left;
            }
            
            /* RTL specific margin and padding adjustments */
            .rtl .ml-auto {
                margin-left: auto;
                margin-right: 0;
            }
            
            .rtl .mr-auto {
                margin-right: auto;
                margin-left: 0;
            }
            
            /* Arabic typography */
            .rtl {
                font-family: 'Amiri', 'Traditional Arabic', 'Arabic Typesetting', 'Tahoma', 'Segoe UI', sans-serif;
            }
            
            .rtl h1, .rtl h2, .rtl h3, .rtl h4, .rtl h5, .rtl h6 {
                font-family: 'Amiri', 'Traditional Arabic', 'Arabic Typesetting', 'Tahoma', sans-serif;
                font-weight: bold;
            }
            
            .rtl p, .rtl span, .rtl div {
                line-height: 1.8;
                font-size: 1.05em;
            }
            
            .top-header {
                background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
                border-bottom: 1px solid #3b82f6;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
                position: sticky;
                top: 0;
                z-index: 100;
                backdrop-filter: blur(10px);
            }
            
            .current-date {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            .current-date::before {
                content: "📅";
                font-size: 14px;
            }
            
            .language-switcher {
                display: flex;
                align-items: center;
                gap: 4px;
                background: rgba(59, 130, 246, 0.1);
                padding: 6px 12px;
                border-radius: 20px;
                border: 1px solid rgba(59, 130, 246, 0.3);
                transition: all 0.3s ease;
            }
            
            .language-switcher:hover {
                background: rgba(59, 130, 246, 0.2);
                border-color: rgba(59, 130, 246, 0.5);
            }
            
            .language-switcher a {
                text-decoration: none;
                transition: all 0.3s ease;
                border-radius: 12px;
                padding: 4px 8px;
            }
            
            .language-switcher a:hover {
                background: rgba(59, 130, 246, 0.3);
                transform: translateY(-1px);
            }
            
            .bismillah {
                font-family: 'Traditional Arabic', serif;
                font-size: 1.3rem;
            }
            
            .bismillah-header {
                margin: 0 20px;
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            
            .bismillah-header span {
                font-family: 'Amiri', 'Traditional Arabic', 'Arabic Typesetting', serif;
                font-size: 18px;
                font-weight: 600;
                letter-spacing: 2px;
                text-align: center;
                white-space: nowrap;
                color: #f5d742;
                text-shadow: 
                    0 0 10px rgba(245, 215, 66, 0.4),
                    0 0 20px rgba(245, 215, 66, 0.2),
                    0 2px 4px rgba(0, 0, 0, 0.3);
                background: linear-gradient(135deg, #ffd700 0%, #f5d742 25%, #ffce44 50%, #f5d742 75%, #ffd700 100%);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                animation: shimmer 3s ease-in-out infinite;
                position: relative;
            }
            
            @keyframes shimmer {
                0%, 100% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
            }
            
            .bismillah-header span::before {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                background: linear-gradient(135deg, transparent, rgba(245, 215, 66, 0.1), transparent);
                border-radius: 8px;
                z-index: -1;
            }
            
            @media (max-width: 768px) {
                .bismillah-header span {
                    font-size: 16px;
                    letter-spacing: 1.5px;
                }
            }
            
            @media (max-width: 480px) {
                .bismillah-header span {
                    font-size: 14px;
                    letter-spacing: 1px;
                }
            }
            
            .brand-name {
                color: #007bff;
                font-weight: bold;
                font-size: 1.8rem;
            }
            
            .date-text {
                font-size: 0.9rem;
                color: #888;
            }
            
            .top-nav-icon {
                color: #007bff;
                margin-right: 5px;
            }
            
            /* RTL specific adjustments for project cards */
            .rtl .project-card-front .absolute.bottom-0 {
                text-align: right;
            }
            
            .rtl .project-card-back {
                text-align: right;
            }
            
            .rtl .flex.items-center.gap-1 svg {
                margin-left: 0.25rem;
                margin-right: 0;
            }
            
            /* Dropdown Styles */
            .dropdown {
                position: relative;
                display: inline-block;
            }
            
            .dropdown-content {
                position: absolute;
                top: 100%;
                left: 0;
                background-color: #1a1a1a;
                border: 1px solid #3b82f6;
                border-radius: 8px;
                min-width: 200px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all 0.3s ease;
                padding: 8px 0;
            }
            
            .dropdown:hover .dropdown-content {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            
            .dropdown-item {
                display: block;
                padding: 12px 16px;
                color: #d1d5db;
                text-decoration: none;
                transition: all 0.3s ease;
                border-left: 3px solid transparent;
            }
            
            .dropdown-item:hover {
                background-color: #374151;
                color: #ffffff;
                border-left-color: #3b82f6;
            }
            
            .dropdown-toggle::after {
                content: '▼';
                font-size: 12px;
                margin-left: 8px;
                transition: transform 0.3s ease;
            }
            
            .dropdown:hover .dropdown-toggle::after {
                transform: rotate(180deg);
            }
            
            /* RTL Dropdown adjustments */
            .rtl .dropdown-content {
                left: auto;
                right: 0;
            }
            
            .rtl .dropdown-item {
                border-left: none;
                border-right: 3px solid transparent;
                text-align: right;
            }
            
            .rtl .dropdown-item:hover {
                border-right-color: #3b82f6;
            }
            
            .rtl .dropdown-toggle::after {
                margin-left: 0;
                margin-right: 8px;
            }
        </style>
        
        @stack('styles')
    </head>
    <body class="bg-black text-white min-h-screen">
        <!-- Background gradient overlay -->
        <div class="fixed inset-0 bg-gradient-to-br from-black via-gray-900 to-black opacity-80 z-0"></div>
        

        <!-- Main content container -->
        <div class="relative z-10 min-h-screen flex flex-col">
            <div class="top-header w-full py-3">
                <div class="container mx-auto flex justify-between items-center px-4 md:px-6">
                    @php
                        use App\Services\DateFormatterService;
                        $currentDate = DateFormatterService::getCurrentDate();
                    @endphp
                    
                    <!-- Current Date Display -->
                    <div class="current-date">
                        <span class="text-sm text-gray-300 font-medium {{ app()->getLocale() === 'ar' ? 'rtl' : '' }}">{{ $currentDate }}</span>
                    </div>
                    
                    <!-- Bismillah -->
                    <div class="bismillah-header">
                        <span>بسم الله الرحمن الرحيم</span>
                    </div>
                    
                    <!-- Language Switcher -->
                    <div class="language-switcher">
                        <a href="{{ route('language.switch', 'en') }}" 
                           class="text-xs font-semibold {{ app()->getLocale() == 'en' ? 'text-blue-300 bg-blue-500/20' : 'text-gray-300 hover:text-white' }}">
                            EN
                        </a>
                        <span class="text-gray-500 text-xs">|</span>
                        <a href="{{ route('language.switch', 'ar') }}" 
                           class="text-xs font-semibold {{ app()->getLocale() == 'ar' ? 'text-blue-300 bg-blue-500/20' : 'text-gray-300 hover:text-white' }}">
                             عربي
                        </a>
                    </div>
                </div>
            </div>
            <!-- Header/Navigation -->
            <header class="w-full py-6">
                <nav class="container mx-auto flex items-center justify-center px-4 md:px-0">
                    <ul class="flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-8 md:space-x-12' : 'space-x-8 md:space-x-12' }}">
                        <li>
                            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }} pb-1 font-medium">{{ __('navigation.home') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }} text-gray-300 transition-colors duration-300">{{ __('navigation.about') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('education') }}" class="nav-link {{ request()->is('education') ? 'active' : '' }} text-gray-300 transition-colors duration-300">{{ __('navigation.education') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('services') }}" class="nav-link {{ request()->is('services') ? 'active' : '' }} text-gray-300 transition-colors duration-300">{{ __('navigation.services') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('projects') }}" class="nav-link {{ request()->is('projects') ? 'active' : '' }} text-gray-300 transition-colors duration-300">{{ __('navigation.projects') }}</a>
                        </li>
                      
                        <!-- Articles Dropdown -->
                        <li class="dropdown">
                            <a href="{{ url('articles') }}" class="nav-link dropdown-toggle {{ request()->is('articles*') ? 'active' : '' }} flex items-center space-x-1 text-gray-300 transition-colors duration-300">
                                <span>{{ __('navigation.articles') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                            <div class="dropdown-content">
                                <a href="{{ url('articles') }}" class="dropdown-item">{{ __('navigation.articles') }}</a>
                                <a href="{{ route('articles.category', 'programming-basics') }}" class="dropdown-item">{{ app()->getLocale() === 'ar' ? 'أساسيات البرمجة' : 'Programming Basics' }}</a>
                                <a href="{{ route('articles.category', 'databases') }}" class="dropdown-item">{{ app()->getLocale() === 'ar' ? 'قواعد البيانات' : 'Database' }}</a>
                                <a href="{{ route('articles.category', 'w') }}" class="dropdown-item">{{ app()->getLocale() === 'ar' ? 'إطارات تطوير الويب' : 'Web Development Framework' }}</a>
                            </div>
                        </li>
                        
                        <!-- Summaries Dropdown -->
                        <li class="dropdown">
                            <a href="{{ url('summaries') }}" class="nav-link dropdown-toggle {{ request()->is('summaries*') ? 'active' : '' }} flex items-center gap-2 text-gray-300 transition-colors duration-300">
                                <!-- PDF icon SVG -->
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                                    <path d="M9 13h1v4H9v-4zm2 0h1.5a1.5 1.5 0 0 1 0 3H11v-3zm1.5 2a.5.5 0 0 0 0-1H12v1h.5zm2-2H16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-1v-4zm1 3v-2h-.5v2h.5z"/>
                                </svg>
                                {{ __('navigation.summaries') }}
                            </a>
                            <div class="dropdown-content">
                                <a href="{{ url('summaries') }}" class="dropdown-item">{{ __('navigation.summaries') }}</a>
                                <a href="{{ url('summaries/books') }}" class="dropdown-item">{{ __('navigation.summaries_books') }}</a>
                                <a href="{{ url('summaries/courses') }}" class="dropdown-item">{{ __('navigation.summaries_courses') }}</a>
                                <a href="{{ url('summaries/documentation') }}" class="dropdown-item">{{ __('navigation.summaries_documentation') }}</a>
                                <a href="{{ url('summaries/research') }}" class="dropdown-item">{{ __('navigation.summaries_research') }}</a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </header>

            <!-- Main Content -->
            <main class="flex-grow">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="py-8 text-gray-500">
                <div class="container mx-auto px-4">
                    <!-- Arabic verse -->
                    <div class="text-center mb-6">
                        <p class="bismillah text-lg mb-2">مَنْ عَمِلَ صَالِحًا مِّن ذَكَرٍ أَوْ أُنثَىٰ وَهُوَ مُؤْمِنٌ فَلَنُحْيِيَنَّهُ حَيَاةً طَيِّبَةً ۖ وَلَنَجْزِيَنَّهُمْ أَجْرَهُم بِأَحْسَنِ مَا كَانُوا يَعْمَلُونَ</p>
                    </div>
                    
                    <!-- Social links -->
                    <div class="flex justify-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-6' : 'space-x-6' }} mb-4">
                        <a href="https://github.com/osamayesh" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/in/osama-ayesh/" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="https://discord.gg/WQJ3uCzY" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286z"/>
                            </svg>
                        </a>
                        <a href="mailto:osamaayeshdx@gmail.com" class="text-gray-400 hover:text-white transition-colors duration-300" target="_blank">
                             <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                   <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1  0-2-.9-2-2V6c0-1.1.9-2 2-2zm0 2v.01L12 13 20 6.01V6H4zm0 2.99V18h16V8.99l-8 6.99-8-6.99z"/>
                              </svg>
                          </a>
                    </div>
                    
                    <p class="text-center">&copy; {{ date('Y') }} Osama Ayesh. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <!-- Visual background elements (keyboard/laptop from screenshot) -->
        <div class="fixed top-0 right-0 w-1/2 h-full z-[-1] opacity-30">
            <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97" alt="Keyboard" class="object-cover h-full w-full">
        </div>
        
        <!-- Prism.js JS (Core and autoloader) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>

        @stack('scripts')

        <script>
            // Configure Prism autoloader
            Prism.plugins.autoloader.languages_path = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';
            
            // Initialize Prism.js for line numbers
            Prism.plugins.NormalizeWhitespace.setDefaults({
                'remove-trailing': true,
                'remove-indent': true,
                'left-trim': true,
                'right-trim': true,
            });

            // Ensure all code blocks are highlighted after page load
            document.addEventListener('DOMContentLoaded', function() {
                // Re-highlight all code blocks to ensure language plugins are applied
                Prism.highlightAll();
                
                // Also manually trigger for any dynamically loaded content
                setTimeout(() => {
                    Prism.highlightAll();
                }, 100);
            });
        </script>
    </body>
</html> 
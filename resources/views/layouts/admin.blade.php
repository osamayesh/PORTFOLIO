<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Portfolio Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .sidebar-link {
            transition: all 0.3s ease;
        }
        
        .sidebar-link:hover {
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3b82f6;
        }
        
        .sidebar-link.active {
            background-color: rgba(59, 130, 246, 0.2);
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
        }
        
        .admin-card {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            border: 1px solid #4b5563;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid #475569;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-900 text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-blue-400">Admin Panel</h2>
                <p class="text-gray-400 text-sm">Portfolio Management</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Categories
                </a>
                
                <a href="{{ route('admin.summary-categories.index') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 {{ request()->routeIs('admin.summary-categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                    </svg>
                    Summary Categories
                </a>
                
                <a href="{{ route('admin.summaries.index') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 {{ request()->routeIs('admin.summaries.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>
                    </svg>
                    Summaries
                </a>
                
                <a href="{{ route('admin.articles.index') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Articles
                </a>
                
                <div class="border-t border-gray-700 mt-6 pt-6">
                    <a href="{{ url('/') }}" 
                       class="sidebar-link flex items-center px-6 py-3 text-gray-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Site
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-gray-800 shadow-sm border-b border-gray-700">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-xl font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-400 text-sm">{{ now()->format('M d, Y') }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg border border-red-600/30 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-900 p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html> 
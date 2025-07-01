<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Portfolio</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .login-bg {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .login-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .login-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .login-button {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        
        .login-button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="login-bg">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Logo/Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Admin Panel</h1>
                <p class="text-gray-400">Sign in to manage your portfolio</p>
            </div>
            
            <!-- Login Card -->
            <div class="login-card rounded-lg p-6 shadow-xl">
                <!-- Success Messages -->
                @if(session('success'))
                    <div class="mb-4 rounded-md bg-green-500/10 border border-green-500/20 p-4">
                        <div class="flex">
                            <div class="ml-3">
                                <p class="text-sm text-green-400">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Error Messages -->
                @if(session('error'))
                    <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/20 p-4">
                        <div class="flex">
                            <div class="ml-3">
                                <p class="text-sm text-red-400">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            class="login-input w-full px-3 py-2 rounded-md text-sm"
                            placeholder="Enter your email"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Password
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="login-input w-full px-3 py-2 rounded-md text-sm"
                            placeholder="Enter your password"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="rounded border-gray-600 bg-gray-700 text-blue-600 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            >
                            <span class="ml-2 text-sm text-gray-300">Remember me</span>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="login-button w-full py-2 px-4 rounded-md text-white font-medium text-sm"
                    >
                        Sign In
                    </button>
                </form>
                
                <!-- Registration Link (if no users exist) -->
                @if(App\Models\User::count() === 0)
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-400">
                            No admin account found? 
                            <a href="{{ route('admin.register') }}" class="text-blue-400 hover:text-blue-300 font-medium">
                                Create first admin account
                            </a>
                        </p>
                    </div>
                @endif
            </div>
            
            <!-- Back to Site -->
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-white transition-colors">
                    ← Back to Portfolio
                </a>
            </div>
        </div>
    </div>
</body>
</html> 
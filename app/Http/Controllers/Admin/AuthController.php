<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        // If already authenticated, redirect to admin dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back to the admin panel!');
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show the admin registration form (optional - for first-time setup)
     */
    public function showRegisterForm()
    {
        // Check if any admin users exist
        if (User::count() > 0) {
            return redirect()->route('admin.login')
                ->with('error', 'Registration is disabled. Admin users already exist.');
        }
        
        return view('admin.auth.register');
    }

    /**
     * Handle admin registration (only for first-time setup)
     */
    public function register(Request $request)
    {
        // Check if any admin users exist
        if (User::count() > 0) {
            return redirect()->route('admin.login')
                ->with('error', 'Registration is disabled. Admin users already exist.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto-verify admin users
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin account created successfully!');
    }
} 
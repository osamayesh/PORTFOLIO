<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
            Config::set('app.locale', $locale);
            
            // Set RTL for Arabic
            if ($locale == 'ar') {
                Session::put('rtl', true);
            } else {
                Session::forget('rtl');
            }
        }
        
        return $next($request);
    }
} 
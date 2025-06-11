<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // More permissive Content Security Policy for development
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://fonts.bunny.net https://fonts.googleapis.com; " .
               "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com https://fonts.bunny.net https://fonts.gstatic.com; " .
               "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net; " .
               "img-src 'self' data: https: blob:; " .
               "connect-src 'self' ws: wss: http://localhost:* https://localhost:*; " .
               "object-src 'none'; " .
               "base-uri 'self';";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
} 
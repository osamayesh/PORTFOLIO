<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            // \App\Http\Middleware\SecurityHeaders::class, // Temporarily disabled
            // \App\Http\Middleware\SqlInjectionProtection::class, // Temporarily disabled
        ]);
        
        // Add CSRF protection to specific admin routes
        $middleware->alias([
            'security' => \App\Http\Middleware\SecurityHeaders::class,
            'secure.upload' => \App\Http\Middleware\SecureFileUpload::class,
            'sql.protection' => \App\Http\Middleware\SqlInjectionProtection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

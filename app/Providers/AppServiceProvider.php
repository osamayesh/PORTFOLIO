<?php

namespace App\Providers;

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Apply locale from session if exists
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
            Config::set('app.locale', $locale);
        }
        
        // Check for RTL direction for Arabic
        view()->composer('*', function ($view) {
            $view->with('rtl', App::getLocale() === 'ar');
        });

        // AI Chat Rate Limiting - Daily limit (1000 requests per day for entire site)
        RateLimiter::for('ai-chat-daily', function (Request $request) {
            return Limit::perDay(1000)->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'success' => false,
                        'error' => app()->getLocale() === 'ar' 
                            ? 'لقد تجاوزت الحد اليومي للاستفسارات. الرجاء المحاولة غداً.' 
                            : 'You have exceeded the daily limit. Please try again tomorrow.',
                        'retry_after' => $headers['Retry-After'] ?? null
                    ], 429);
                });
        });

        // AI Chat Rate Limiting - Per minute limit (10 requests per minute)
        RateLimiter::for('ai-chat-minute', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'success' => false,
                        'error' => app()->getLocale() === 'ar' 
                            ? 'الرجاء الانتظار قليلاً قبل إرسال سؤال آخر.' 
                            : 'Please wait a moment before sending another question.',
                        'retry_after' => $headers['Retry-After'] ?? null
                    ], 429);
                });
        });
    }
}

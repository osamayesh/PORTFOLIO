<?php

namespace App\Providers;

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

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
    }
}

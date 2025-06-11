<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     *
     * @param string $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        // Check if language exists
        if (in_array($lang, ['en', 'ar'])) {
            // Store the locale in the session
            Session::put('locale', $lang);
            
            // Set the application locale
            App::setLocale($lang);
            
            // Update config value
            Config::set('app.locale', $lang);
            
            // Log for debugging
            Log::info('Language switched', [
                'locale' => $lang, 
                'session_locale' => Session::get('locale'),
                'app_locale' => App::getLocale(),
                'config_locale' => Config::get('app.locale')
            ]);
            
            // Add RTL class for Arabic language
            if ($lang == 'ar') {
                Session::put('rtl', true);
            } else {
                Session::forget('rtl');
            }
        }
        
        // Redirect back to the previous page
        return redirect()->back()->with('locale_changed', 'Language changed to ' . $lang);
    }
} 
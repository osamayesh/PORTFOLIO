<?php

namespace App\Services;

use App\Models\DateTranslation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DateFormatterService
{
    /**
     * Format date according to locale using database translations
     */
    public static function formatDate(Carbon $date, string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'ar') {
            return self::formatArabicDate($date);
        }

        return self::formatEnglishDate($date);
    }

    /**
     * Format date in Arabic using database translations
     */
    private static function formatArabicDate(Carbon $date): string
    {
        // Cache translations for better performance
        $translations = Cache::remember("date_translations_ar", 3600, function () {
            return DateTranslation::getAllForLocale('ar');
        });

        $dayName = $translations['days'][$date->format('l')] ?? $date->format('l');
        $monthName = $translations['months'][$date->format('F')] ?? $date->format('F');

        return $dayName . '، ' . $date->format('j') . ' ' . $monthName . ' ' . $date->format('Y') . ' م';
    }

    /**
     * Format date in English using database translations
     */
    private static function formatEnglishDate(Carbon $date): string
    {
        // Cache translations for better performance
        $translations = Cache::remember("date_translations_en", 3600, function () {
            return DateTranslation::getAllForLocale('en');
        });

        $dayName = $translations['days'][$date->format('l')] ?? $date->format('l');
        $monthName = $translations['months'][$date->format('F')] ?? $date->format('F');

        return $dayName . ', ' . $monthName . ' ' . $date->format('j') . ', ' . $date->format('Y');
    }

    /**
     * Get current formatted date
     */
    public static function getCurrentDate(string $locale = null): string
    {
        return self::formatDate(Carbon::now(), $locale);
    }

    /**
     * Clear date translations cache
     */
    public static function clearCache(): void
    {
        Cache::forget('date_translations_ar');
        Cache::forget('date_translations_en');
    }
} 
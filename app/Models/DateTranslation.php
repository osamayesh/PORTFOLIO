<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateTranslation extends Model
{
    protected $fillable = [
        'type',
        'key',
        'locale',
        'value',
        'order_number'
    ];

    /**
     * Get day translations for a specific locale
     */
    public static function getDaysForLocale(string $locale): array
    {
        return self::where('type', 'day')
            ->where('locale', $locale)
            ->orderBy('order_number')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get month translations for a specific locale
     */
    public static function getMonthsForLocale(string $locale): array
    {
        return self::where('type', 'month')
            ->where('locale', $locale)
            ->orderBy('order_number')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get all date translations for a specific locale
     */
    public static function getAllForLocale(string $locale): array
    {
        $translations = self::where('locale', $locale)
            ->get()
            ->groupBy('type');

        return [
            'days' => $translations->get('day', collect())->pluck('value', 'key')->toArray(),
            'months' => $translations->get('month', collect())->pluck('value', 'key')->toArray(),
        ];
    }
}

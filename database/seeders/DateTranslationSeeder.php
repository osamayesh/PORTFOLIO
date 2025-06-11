<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DateTranslation;

class DateTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DateTranslation::truncate();

        // Days data
        $days = [
            ['key' => 'Monday', 'ar' => 'الاثنين', 'en' => 'Monday', 'order' => 1],
            ['key' => 'Tuesday', 'ar' => 'الثلاثاء', 'en' => 'Tuesday', 'order' => 2],
            ['key' => 'Wednesday', 'ar' => 'الأربعاء', 'en' => 'Wednesday', 'order' => 3],
            ['key' => 'Thursday', 'ar' => 'الخميس', 'en' => 'Thursday', 'order' => 4],
            ['key' => 'Friday', 'ar' => 'الجمعة', 'en' => 'Friday', 'order' => 5],
            ['key' => 'Saturday', 'ar' => 'السبت', 'en' => 'Saturday', 'order' => 6],
            ['key' => 'Sunday', 'ar' => 'الأحد', 'en' => 'Sunday', 'order' => 7],
        ];

        // Months data
        $months = [
            ['key' => 'January', 'ar' => 'يناير', 'en' => 'January', 'order' => 1],
            ['key' => 'February', 'ar' => 'فبراير', 'en' => 'February', 'order' => 2],
            ['key' => 'March', 'ar' => 'مارس', 'en' => 'March', 'order' => 3],
            ['key' => 'April', 'ar' => 'أبريل', 'en' => 'April', 'order' => 4],
            ['key' => 'May', 'ar' => 'مايو', 'en' => 'May', 'order' => 5],
            ['key' => 'June', 'ar' => 'يونيو', 'en' => 'June', 'order' => 6],
            ['key' => 'July', 'ar' => 'يوليو', 'en' => 'July', 'order' => 7],
            ['key' => 'August', 'ar' => 'أغسطس', 'en' => 'August', 'order' => 8],
            ['key' => 'September', 'ar' => 'سبتمبر', 'en' => 'September', 'order' => 9],
            ['key' => 'October', 'ar' => 'أكتوبر', 'en' => 'October', 'order' => 10],
            ['key' => 'November', 'ar' => 'نوفمبر', 'en' => 'November', 'order' => 11],
            ['key' => 'December', 'ar' => 'ديسمبر', 'en' => 'December', 'order' => 12],
        ];

        // Insert days
        foreach ($days as $day) {
            // Arabic translation
            DateTranslation::create([
                'type' => 'day',
                'key' => $day['key'],
                'locale' => 'ar',
                'value' => $day['ar'],
                'order_number' => $day['order']
            ]);

            // English translation
            DateTranslation::create([
                'type' => 'day',
                'key' => $day['key'],
                'locale' => 'en',
                'value' => $day['en'],
                'order_number' => $day['order']
            ]);
        }

        // Insert months
        foreach ($months as $month) {
            // Arabic translation
            DateTranslation::create([
                'type' => 'month',
                'key' => $month['key'],
                'locale' => 'ar',
                'value' => $month['ar'],
                'order_number' => $month['order']
            ]);

            // English translation
            DateTranslation::create([
                'type' => 'month',
                'key' => $month['key'],
                'locale' => 'en',
                'value' => $month['en'],
                'order_number' => $month['order']
            ]);
        }

        $this->command->info('Date translations seeded successfully!');
    }
}

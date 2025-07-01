<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Remove the test user creation since we're using AdminUserSeeder
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed categories, articles, and date translations
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            DateTranslationSeeder::class,
        ]);
    }
}

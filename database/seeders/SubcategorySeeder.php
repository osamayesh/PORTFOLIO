<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some main categories to add subcategories to
        $webDev = Category::where('slug', 'programming-basics')->first();
        $advanced = Category::where('slug', 'advanced-topics')->first();
        $databases = Category::where('slug', 'databases')->first();

        if ($webDev) {
            // Add subcategories to Programming Basics
            $subcategories = [
                [
                    'parent_id' => $webDev->id,
                    'name' => 'HTML Basics',
                    'name_ar' => 'أساسيات HTML',
                    'slug' => 'html-basics',
                    'description' => 'Learn the fundamentals of HTML markup language',
                    'sort_order' => 10,
                    'is_active' => true
                ],
                [
                    'parent_id' => $webDev->id,
                    'name' => 'CSS Styling',
                    'name_ar' => 'تنسيق CSS',
                    'slug' => 'css-styling',
                    'description' => 'Styling web pages with CSS',
                    'sort_order' => 20,
                    'is_active' => true
                ],
                [
                    'parent_id' => $webDev->id,
                    'name' => 'JavaScript Basics',
                    'name_ar' => 'أساسيات JavaScript',
                    'slug' => 'javascript-basics',
                    'description' => 'Introduction to JavaScript programming',
                    'sort_order' => 30,
                    'is_active' => true
                ]
            ];

            foreach ($subcategories as $subcategory) {
                Category::firstOrCreate(
                    ['slug' => $subcategory['slug']],
                    $subcategory
                );
            }
        }

        if ($advanced) {
            // Add subcategories to Advanced Topics
            $subcategories = [
                [
                    'parent_id' => $advanced->id,
                    'name' => 'Microservices',
                    'name_ar' => 'الخدمات المصغرة',
                    'slug' => 'microservices',
                    'description' => 'Building scalable microservice architectures',
                    'sort_order' => 10,
                    'is_active' => true
                ],
                [
                    'parent_id' => $advanced->id,
                    'name' => 'Docker & Containers',
                    'name_ar' => 'Docker والحاويات',
                    'slug' => 'docker-containers',
                    'description' => 'Containerization with Docker',
                    'sort_order' => 20,
                    'is_active' => true
                ]
            ];

            foreach ($subcategories as $subcategory) {
                Category::firstOrCreate(
                    ['slug' => $subcategory['slug']],
                    $subcategory
                );
            }
        }

        if ($databases) {
            // Add subcategories to Databases
            $subcategories = [
                [
                    'parent_id' => $databases->id,
                    'name' => 'MySQL',
                    'name_ar' => 'MySQL',
                    'slug' => 'mysql',
                    'description' => 'MySQL database management and optimization',
                    'sort_order' => 10,
                    'is_active' => true
                ],
                [
                    'parent_id' => $databases->id,
                    'name' => 'NoSQL',
                    'name_ar' => 'NoSQL',
                    'slug' => 'nosql',
                    'description' => 'NoSQL databases like MongoDB, Redis',
                    'sort_order' => 20,
                    'is_active' => true
                ]
            ];

            foreach ($subcategories as $subcategory) {
                Category::firstOrCreate(
                    ['slug' => $subcategory['slug']],
                    $subcategory
                );
            }
        }
    }
}

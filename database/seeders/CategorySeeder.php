<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Categories expected by ArticleSeeder
            [
                'name' => 'Programming Basics',
                'name_ar' => 'أساسيات البرمجة',
                'slug' => 'programming-basics',
                'description' => 'Fundamental programming concepts and basics',
                'sort_order' => 10,
                'is_active' => true
            ],
            [
                'name' => 'OOP Principles',
                'name_ar' => 'مبادئ البرمجة الكائنية',
                'slug' => 'oop-principles',
                'description' => 'Object-oriented programming principles and concepts',
                'sort_order' => 20,
                'is_active' => true
            ],
            [
                'name' => 'Data Structures',
                'name_ar' => 'هياكل البيانات',
                'slug' => 'data-structures',
                'description' => 'Data structures and algorithms',
                'sort_order' => 30,
                'is_active' => true
            ],
            [
                'name' => 'Design Patterns',
                'name_ar' => 'أنماط التصميم',
                'slug' => 'design-patterns',
                'description' => 'Software design patterns and best practices',
                'sort_order' => 40,
                'is_active' => true
            ],
            [
                'name' => 'API Development',
                'name_ar' => 'تطوير واجهات التطبيقات',
                'slug' => 'api-development',
                'description' => 'API development and integration',
                'sort_order' => 50,
                'is_active' => true
            ],
            [
                'name' => 'JavaScript Fundamentals',
                'name_ar' => 'أساسيات جافا سكريبت',
                'slug' => 'javascript-fundamentals',
                'description' => 'JavaScript programming fundamentals',
                'sort_order' => 60,
                'is_active' => true
            ],
            [
                'name' => 'Git Version Control',
                'name_ar' => 'التحكم بالإصدارات Git',
                'slug' => 'git-version-control',
                'description' => 'Git version control and collaboration',
                'sort_order' => 70,
                'is_active' => true
            ],
            [
                'name' => 'Databases',
                'name_ar' => 'قواعد البيانات',
                'slug' => 'databases',
                'description' => 'Database design and management',
                'sort_order' => 80,
                'is_active' => true
            ],
            [
                'name' => 'Advanced Topics',
                'name_ar' => 'مواضيع متقدمة',
                'slug' => 'advanced-topics',
                'description' => 'Advanced programming topics and concepts',
                'sort_order' => 90,
                'is_active' => true
            ],
            [
                'name' => 'Personal Blog',
                'name_ar' => 'مدونة شخصية',
                'slug' => 'personal-blog',
                'description' => 'Personal thoughts and experiences',
                'sort_order' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Tutorials',
                'name_ar' => 'دروس تعليمية',
                'slug' => 'tutorials',
                'description' => 'Step-by-step tutorials and guides',
                'sort_order' => 110,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}

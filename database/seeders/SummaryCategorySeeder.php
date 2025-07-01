<?php

namespace Database\Seeders;

use App\Models\SummaryCategory;
use Illuminate\Database\Seeder;

class SummaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'API World',
                'name_ar' => 'عالم الـ API',
                'slug' => 'api',
                'description' => 'API development, REST, GraphQL and web services',
                'description_ar' => 'تطوير الـ API، REST، GraphQL وخدمات الويب',
                'color' => 'blue',
                'icon' => '<path d="M12 0L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>',
                'sort_order' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Git and Beyond',
                'name_ar' => 'الـ Git وما وراءه',
                'slug' => 'git',
                'description' => 'Version control, Git workflows and collaboration',
                'description_ar' => 'إدارة الإصدارات، سير عمل Git والتعاون',
                'color' => 'orange',
                'icon' => '<path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>',
                'sort_order' => 20,
                'is_active' => true
            ],
            [
                'name' => 'Advanced Programming',
                'name_ar' => 'متقدم',
                'slug' => 'advanced',
                'description' => 'Advanced programming concepts and techniques',
                'description_ar' => 'مفاهيم وتقنيات البرمجة المتقدمة',
                'color' => 'purple',
                'icon' => '<path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>',
                'sort_order' => 30,
                'is_active' => true
            ],
            [
                'name' => 'Books',
                'name_ar' => 'الكتب',
                'slug' => 'books',
                'description' => 'Programming books summaries and reviews',
                'description_ar' => 'ملخصات ومراجعات كتب البرمجة',
                'color' => 'green',
                'icon' => '<path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z"/>',
                'sort_order' => 40,
                'is_active' => true
            ],
            [
                'name' => 'Courses',
                'name_ar' => 'الكورسات',
                'slug' => 'courses',
                'description' => 'Online courses and learning materials',
                'description_ar' => 'الكورسات الأونلاين ومواد التعلم',
                'color' => 'yellow',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                'sort_order' => 50,
                'is_active' => true
            ],
            [
                'name' => 'Documentation',
                'name_ar' => 'التوثيق',
                'slug' => 'documentation',
                'description' => 'Project documentation and technical writing',
                'description_ar' => 'توثيق المشاريع والكتابة التقنية',
                'color' => 'emerald',
                'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 4h7v5h5v11H6V4z"/>',
                'sort_order' => 60,
                'is_active' => true
            ],
            [
                'name' => 'Frameworks',
                'name_ar' => 'أطر العمل',
                'slug' => 'frameworks',
                'description' => 'Frontend and backend frameworks',
                'description_ar' => 'أطر عمل الواجهات الأمامية والخلفية',
                'color' => 'cyan',
                'icon' => '<path d="M12 0L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z"/>',
                'sort_order' => 70,
                'is_active' => true
            ],
            [
                'name' => 'Databases',
                'name_ar' => 'قواعد البيانات',
                'slug' => 'databases',
                'description' => 'Database design, SQL and NoSQL',
                'description_ar' => 'تصميم قواعد البيانات، SQL وNoSQL',
                'color' => 'yellow',
                'icon' => '<path d="M12 2C9.243 2 7 2.895 7 4v2c0 1.105 2.243 2 5 2s5-.895 5-2V4c0-1.105-2.243-2-5-2zM7 8v2c0 1.105 2.243 2 5 2s5-.895 5-2V8c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 12v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 16v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2z"/>',
                'sort_order' => 80,
                'is_active' => true
            ],
            [
                'name' => 'Security',
                'name_ar' => 'الأمان',
                'slug' => 'security',
                'description' => 'Cybersecurity and application security',
                'description_ar' => 'الأمن السيبراني وأمان التطبيقات',
                'color' => 'red',
                'icon' => '<path d="M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5zM10 17l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>',
                'sort_order' => 90,
                'is_active' => true
            ],
            [
                'name' => 'DevOps',
                'name_ar' => 'الـ DevOps',
                'slug' => 'devops',
                'description' => 'CI/CD, containerization and cloud deployment',
                'description_ar' => 'CI/CD، الحاويات ونشر السحابة',
                'color' => 'indigo',
                'icon' => '<path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-10-5z"/>',
                'sort_order' => 100,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            SummaryCategory::create($category);
        }
    }
}

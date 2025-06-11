<?php

namespace Database\Seeders;

use App\Models\Summary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SummarySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $summaries = [
            [
                'title_en' => 'What are the most important types of Status Codes?',
                'title_ar' => 'ما أهم أنواع الـ Status Codes ؟',
                'description_en' => 'Why should we know these codes, what do they symbolize? And what is the purpose of their existence?',
                'description_ar' => 'لما على معرفة هذه الرموز، وإلى ماذا ترمز ؟ وما الغرض من وجودها ؟',
                'category' => 'api',
                'pdf_file_path' => 'status-codes-summary.pdf',
                'color_scheme' => 'blue',
                'published_date' => Carbon::parse('2024-03-27'),
                'sort_order' => 1
            ],
            [
                'title_en' => 'OOP Principles',
                'title_ar' => 'مبادئ الـ OOP',
                'description_en' => 'Basic principles of object-oriented programming and how to apply them in development',
                'description_ar' => 'مبادئ البرمجة الكائنية الأساسية وكيفية تطبيقها في التطوير',
                'category' => 'api',
                'pdf_file_path' => 'oop-principles-summary.pdf',
                'color_scheme' => 'green',
                'published_date' => Carbon::parse('2024-03-15'),
                'sort_order' => 2
            ],
            [
                'title_en' => 'Git Basics and Version Control',
                'title_ar' => 'أساسيات Git وإدارة النسخ',
                'description_en' => 'Learn Git basics and how to manage versions and collaborate on projects',
                'description_ar' => 'تعلم أساسيات Git وكيفية إدارة النسخ والتعاون في المشاريع',
                'category' => 'git',
                'pdf_file_path' => 'git-basics-summary.pdf',
                'color_scheme' => 'orange',
                'published_date' => Carbon::parse('2024-03-10'),
                'sort_order' => 1
            ],
            [
                'title_en' => 'Advanced Git Workflows',
                'title_ar' => 'سير العمل المتقدم في Git',
                'description_en' => 'Advanced Git techniques, branching strategies, and collaborative workflows',
                'description_ar' => 'تقنيات Git المتقدمة، استراتيجيات التفرع، وسير العمل التعاوني',
                'category' => 'git',
                'pdf_file_path' => 'advanced-git-workflows.pdf',
                'color_scheme' => 'orange',
                'published_date' => Carbon::parse('2024-03-08'),
                'sort_order' => 2
            ],
            [
                'title_en' => 'Advanced Programming Concepts',
                'title_ar' => 'مفاهيم متقدمة في البرمجة',
                'description_en' => 'Exploring advanced concepts in programming and architectural design',
                'description_ar' => 'استكشاف المفاهيم المتقدمة في البرمجة والتصميم المعماري',
                'category' => 'advanced',
                'pdf_file_path' => 'advanced-programming-summary.pdf',
                'color_scheme' => 'purple',
                'published_date' => Carbon::parse('2024-03-05'),
                'sort_order' => 1
            ],
            [
                'title_en' => 'Clean Code Principles',
                'title_ar' => 'مبادئ الكود النظيف',
                'description_en' => 'Best practices for writing clean, maintainable, and readable code',
                'description_ar' => 'أفضل الممارسات لكتابة كود نظيف وقابل للصيانة والقراءة',
                'category' => 'books',
                'pdf_file_path' => 'clean-code-principles.pdf',
                'color_scheme' => 'green',
                'published_date' => Carbon::parse('2024-02-28'),
                'sort_order' => 1
            ],
            [
                'title_en' => 'Laravel Best Practices',
                'title_ar' => 'أفضل ممارسات Laravel',
                'description_en' => 'Complete guide to Laravel framework best practices and patterns',
                'description_ar' => 'دليل شامل لأفضل ممارسات وأنماط إطار عمل Laravel',
                'category' => 'courses',
                'pdf_file_path' => 'laravel-best-practices.pdf',
                'color_scheme' => 'blue',
                'published_date' => Carbon::parse('2024-02-20'),
                'sort_order' => 1
            ]
        ];

        foreach ($summaries as $summary) {
            Summary::create($summary);
        }
    }
}

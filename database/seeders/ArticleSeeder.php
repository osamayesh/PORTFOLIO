<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $programmingBasics = Category::where('slug', 'programming-basics')->first();
        $oop = Category::where('slug', 'oop-principles')->first();
        $dataStructures = Category::where('slug', 'data-structures')->first();
        $designPatterns = Category::where('slug', 'design-patterns')->first();
        $api = Category::where('slug', 'api-development')->first();
        $javascript = Category::where('slug', 'javascript-fundamentals')->first();
        $git = Category::where('slug', 'git-version-control')->first();
        $databases = Category::where('slug', 'databases')->first();
        $advanced = Category::where('slug', 'advanced-topics')->first();
        $personal = Category::where('slug', 'personal-blog')->first();
        $tutorials = Category::where('slug', 'tutorials')->first();

        $articles = [
            // Programming Basics Articles
            [
                'category_id' => $programmingBasics->id,
                'title' => 'ما هي البرمجة ؟',
                'slug' => 'what-is-programming',
                'description' => 'تعريف عن البرمجة وأهميتها والمجالات الخاصة بها',
                'content' => 'البرمجة هي فن وعلم كتابة التعليمات للحاسوب لحل المشاكل وأتمتة المهام. في هذا المقال، سنتعرف على أساسيات البرمجة...',
                'read_time' => 5,
                'is_published' => true,
                'published_at' => Carbon::parse('2024-08-09'),
                'tags' => ['برمجة', 'أساسيات', 'مبتدئين']
            ],
            [
                'category_id' => $programmingBasics->id,
                'title' => 'ما هي المتغيرات وأنواع البيانات ؟',
                'slug' => 'variables-and-data-types',
                'description' => 'شرح ما هي المتغيرات وأنواع البيانات في البرمجة وكيف يتم تخزينها في ذاكرة الجهاز',
                'content' => 'المتغيرات هي حاويات لتخزين البيانات في البرمجة. تختلف أنواع البيانات حسب نوع المعلومات المخزنة...',
                'read_time' => 7,
                'is_published' => true,
                'published_at' => Carbon::parse('2024-08-09'),
                'tags' => ['متغيرات', 'أنواع البيانات', 'أساسيات']
            ],
            [
                'category_id' => $programmingBasics->id,
                'title' => 'قاعدة if في البرمجة ؟',
                'slug' => 'if-statement-programming',
                'description' => 'شرح لأداة الشرط في البرمجة if, else وكيف تستخدمها لتحكم في مسار الكود',
                'content' => 'جملة if هي إحدى أهم أدوات التحكم في مسار البرنامج. تسمح لنا بتنفيذ كود معين بناءً على شرط محدد...',
                'read_time' => 6,
                'is_published' => true,
                'published_at' => Carbon::parse('2024-08-17'),
                'tags' => ['if', 'شروط', 'تحكم']
            ],
            [
                'category_id' => $programmingBasics->id,
                'title' => 'العمليات الحسابية في البرمجة',
                'slug' => 'mathematical-operations-programming',
                'description' => 'شرح العمليات الحسابية المختلفة في البرمجة من جمع وطرح وضرب وغيرها مع أمثلة تطبيقية',
                'content' => 'العمليات الحسابية هي أساس معظم البرامج. سنتعلم كيفية استخدام الجمع والطرح والضرب والقسمة...',
                'read_time' => 8,
                'is_published' => true,
                'published_at' => Carbon::parse('2024-08-13'),
                'tags' => ['عمليات حسابية', 'رياضيات', 'أساسيات']
            ],
            [
                'category_id' => $programmingBasics->id,
                'title' => 'ما هو أمر الـ switch في البرمجة ؟',
                'slug' => 'switch-statement-programming',
                'description' => 'شرح لأداة switch في البرمجة وكيف تستخدمها للتحكم في مسار الكود بناء على قيمة معينة',
                'content' => 'أداة switch هي بديل أنيق لاستخدام multiple if statements. تسمح بفحص قيمة متغير مقابل عدة احتمالات...',
                'read_time' => 6,
                'is_published' => true,
                'published_at' => Carbon::parse('2024-08-20'),
                'tags' => ['switch', 'تحكم', 'شروط']
            ],
            [
                'category_id' => $programmingBasics->id,
                'title' => 'المصفوفات في البرمجة، Arrays !',
                'slug' => 'arrays-programming',
                'description' => 'شرح لمفهوم المصفوفات في البرمجة وكيفية استخدامها والتعامل معها',
                'content' => 'المصفوفات (Arrays) هي هياكل بيانات تسمح بتخزين مجموعة من العناصر في متغير واحد...',
                'read_time' => 9,
                'is_published' => true,
                'published_at' => Carbon::parse('2024-08-22'),
                'tags' => ['مصفوفات', 'arrays', 'هياكل بيانات']
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        // Add some random articles for other categories to reach the counts shown in your image
        $this->createAdditionalArticles($oop, 6);
        $this->createAdditionalArticles($dataStructures, 6);
        $this->createAdditionalArticles($designPatterns, 1);
        $this->createAdditionalArticles($api, 3);
        $this->createAdditionalArticles($javascript, 4);
        $this->createAdditionalArticles($git, 3);
        $this->createAdditionalArticles($databases, 2);
        $this->createAdditionalArticles($advanced, 5);
        $this->createAdditionalArticles($personal, 2);
        $this->createAdditionalArticles($tutorials, 6);
        
        // Add more articles to programming basics to reach 12 total
        $this->createAdditionalArticles($programmingBasics, 6);
    }

    private function createAdditionalArticles($category, $count)
    {
        for ($i = 1; $i <= $count; $i++) {
            Article::create([
                'category_id' => $category->id,
                'title' => "مقال {$i} في {$category->name_ar}",
                'slug' => Str::slug("article-{$i}-{$category->slug}"),
                'description' => "وصف مقال {$i} في فئة {$category->name_ar}",
                'content' => "محتوى مقال {$i} في فئة {$category->name_ar}. هذا نص تجريبي للمقال...",
                'read_time' => rand(3, 12),
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 100)),
                'tags' => [$category->name, 'مقال', 'تجريبي']
            ]);
        }
    }
}

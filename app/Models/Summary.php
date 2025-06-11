<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'category',
        'category_slug',
        'pdf_file_path',
        'color_scheme',
        'published_date',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Get title based on current locale
    public function getTitle()
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    // Get description based on current locale
    public function getDescription()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    // Get formatted date based on current locale
    public function getFormattedDate()
    {
        $date = $this->published_date;
        
        if (app()->getLocale() === 'ar') {
            $days = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
            $months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
            
            $dayName = $days[$date->dayOfWeek];
            $monthName = $months[$date->month - 1];
            
            return "{$dayName}، {$date->day} {$monthName} {$date->year} م";
        } else {
            return $date->format('l, F d, Y');
        }
    }

    // Get full PDF URL
    public function getPdfUrl()
    {
        return asset('storage/pdfs/' . $this->pdf_file_path);
    }

    // Scope for active summaries
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for specific category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Get color classes based on color scheme
    public function getColorClasses()
    {
        $colors = [
            'blue' => [
                'bg' => 'bg-blue-500/20',
                'hover' => 'group-hover:bg-blue-500/30',
                'text' => 'text-blue-400',
                'hover_text' => 'group-hover:text-blue-400',
                'border' => 'hover:border-blue-400',
                'button' => 'bg-blue-600 hover:bg-blue-700'
            ],
            'green' => [
                'bg' => 'bg-green-500/20',
                'hover' => 'group-hover:bg-green-500/30',
                'text' => 'text-green-400',
                'hover_text' => 'group-hover:text-green-400',
                'border' => 'hover:border-green-400',
                'button' => 'bg-green-600 hover:bg-green-700'
            ],
            'orange' => [
                'bg' => 'bg-orange-500/20',
                'hover' => 'group-hover:bg-orange-500/30',
                'text' => 'text-orange-400',
                'hover_text' => 'group-hover:text-orange-400',
                'border' => 'hover:border-orange-400',
                'button' => 'bg-orange-600 hover:bg-orange-700'
            ],
            'purple' => [
                'bg' => 'bg-purple-500/20',
                'hover' => 'group-hover:bg-purple-500/30',
                'text' => 'text-purple-400',
                'hover_text' => 'group-hover:text-purple-400',
                'border' => 'hover:border-purple-400',
                'button' => 'bg-purple-600 hover:bg-purple-700'
            ]
        ];

        return $colors[$this->color_scheme] ?? $colors['blue'];
    }

    // Relationship to SummaryCategory
    public function summaryCategory()
    {
        return $this->belongsTo(SummaryCategory::class, 'category_slug', 'slug');
    }

    // Get category (fallback to old system if no category_slug)
    public function getCategoryInfo()
    {
        if ($this->category_slug && $this->summaryCategory) {
            return $this->summaryCategory;
        }
        
        // Fallback to old hardcoded system
        return (object) [
            'name' => ucfirst($this->category),
            'name_ar' => $this->getOldCategoryNameAr(),
            'slug' => $this->category,
            'color' => $this->color_scheme ?? 'blue'
        ];
    }

    private function getOldCategoryNameAr()
    {
        $translations = [
            'api' => 'عالم الـ API',
            'git' => 'الـ Git وما وراءه', 
            'advanced' => 'متقدم',
            'books' => 'الكتب',
            'courses' => 'الكورسات',
            'documentation' => 'التوثيق',
            'frameworks' => 'أطر العمل',
            'databases' => 'قواعد البيانات',
            'security' => 'الأمان',
            'devops' => 'الـ DevOps'
        ];
        
        return $translations[$this->category] ?? ucfirst($this->category);
    }
}

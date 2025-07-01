<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'title',
        'title_en',
        'title_ar',
        'description',
        'description_en',
        'description_ar',
        'table_data',
        'table_data_en',
        'table_data_ar',
        'order',
        'show_header',
        'show_borders',
        'striped_rows',
        'table_style'
    ];

    protected $casts = [
        'table_data' => 'array',
        'table_data_en' => 'array',
        'table_data_ar' => 'array',
        'show_header' => 'boolean',
        'show_borders' => 'boolean',
        'striped_rows' => 'boolean'
    ];

    /**
     * Get the article that owns this comparison table
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get localized title based on current locale
     */
    public function getLocalizedTitle(): ?string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'ar') {
            return $this->title_ar ?: $this->title_en ?: $this->title;
        }
        
        return $this->title_en ?: $this->title;
    }

    /**
     * Get localized description based on current locale
     */
    public function getLocalizedDescription(): ?string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'ar') {
            return $this->description_ar ?: $this->description_en ?: $this->description;
        }
        
        return $this->description_en ?: $this->description;
    }

    /**
     * Get localized table data based on current locale
     */
    public function getLocalizedTableData(): array
    {
        $locale = app()->getLocale();
        
        if ($locale === 'ar') {
            return $this->table_data_ar ?: $this->table_data_en ?: $this->table_data ?: [];
        }
        
        return $this->table_data_en ?: $this->table_data ?: [];
    }

    /**
     * Get table CSS classes based on style and options
     */
    public function getTableClasses(): string
    {
        $classes = ['comparison-table', 'w-full'];
        
        if ($this->show_borders) {
            $classes[] = 'border-collapse';
        }
        
        switch ($this->table_style) {
            case 'compact':
                $classes[] = 'table-compact';
                break;
            case 'modern':
                $classes[] = 'table-modern';
                break;
            default:
                $classes[] = 'table-default';
                break;
        }
        
        if ($this->striped_rows) {
            $classes[] = 'table-striped';
        }
        
        return implode(' ', $classes);
    }

    /**
     * Check if table has valid data
     */
    public function hasValidData(): bool
    {
        $data = $this->getLocalizedTableData();
        return !empty($data) && !empty($data['headers']) && !empty($data['rows']);
    }
}

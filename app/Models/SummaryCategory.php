<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SummaryCategory extends Model
{
    protected $fillable = [
        'name',
        'name_ar', 
        'slug',
        'description',
        'description_ar',
        'color',
        'icon',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function summaries(): HasMany
    {
        return $this->hasMany(Summary::class, 'category_slug', 'slug');
    }

    public function activeSummaries(): HasMany
    {
        return $this->summaries()->where('is_active', true);
    }

    public function getName()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name;
    }

    public function getDescription()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description;
    }

    public function getSummaryCountAttribute(): int
    {
        return $this->activeSummaries()->count();
    }
}

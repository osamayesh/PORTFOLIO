<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'name_ar',
        'slug',
        'description',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function publishedArticles(): HasMany
    {
        return $this->hasMany(Article::class)->where('is_published', true);
    }

    public function getArticleCountAttribute(): int
    {
        return $this->publishedArticles()->count();
    }

    // Parent-child relationships for subcategories
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    public function subcategories(): HasMany
    {
        return $this->children();
    }

    // Get only main categories (no parent)
    public function scopeMainCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    // Get only subcategories (have parent)
    public function scopeSubcategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Check if this is a main category
    public function isMainCategory(): bool
    {
        return $this->parent_id === null;
    }

    // Check if this is a subcategory
    public function isSubcategory(): bool
    {
        return $this->parent_id !== null;
    }

    // Get full category path (Parent > Child)
    public function getFullNameAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->name . ' > ' . $this->name;
        }
        return $this->name;
    }

    // Get full category path in Arabic (Parent > Child)
    public function getFullNameArAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->name_ar . ' > ' . $this->name_ar;
        }
        return $this->name_ar;
    }

    // Get all articles including from subcategories
    public function allArticles(): HasMany
    {
        if ($this->isMainCategory()) {
            // Get articles from this category and all its subcategories
            $subcategoryIds = $this->children->pluck('id')->toArray();
            $allIds = array_merge([$this->id], $subcategoryIds);
            
            return $this->hasMany(Article::class)->whereIn('category_id', $allIds);
        }
        
        // For subcategories, just return their own articles
        return $this->articles();
    }

    // Get count of all articles including subcategories
    public function getTotalArticleCountAttribute(): int
    {
        if ($this->isMainCategory()) {
            $count = $this->publishedArticles()->count();
            foreach ($this->children as $child) {
                $count += $child->publishedArticles()->count();
            }
            return $count;
        }
        
        return $this->getArticleCountAttribute();
    }
}

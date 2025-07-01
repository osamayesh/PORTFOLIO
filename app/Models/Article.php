<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\ArticleView;

class Article extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'title_en',
        'title_ar',
        'description',
        'description_en',
        'description_ar',
        'content',
        'content_en',
        'content_ar',
        'featured_image',
        'tags',
        'read_time',
        'views',
        'is_published',
        'published_at',
        'prerequisites',
        'prerequisites_ar',
        'series_id',
        'series_order',
        'programming_language',
        'framework',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
        'read_time' => 'integer'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function codeSnippets(): HasMany
    {
        return $this->hasMany(CodeSnippet::class)->orderBy('order');
    }

    public function articleViews(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', "%{$searchTerm}%")
              ->orWhere('title_en', 'LIKE', "%{$searchTerm}%")
              ->orWhere('title_ar', 'LIKE', "%{$searchTerm}%")
              ->orWhere('description', 'LIKE', "%{$searchTerm}%")
              ->orWhere('description_en', 'LIKE', "%{$searchTerm}%")
              ->orWhere('description_ar', 'LIKE', "%{$searchTerm}%")
              ->orWhere('content', 'LIKE', "%{$searchTerm}%")
              ->orWhere('content_en', 'LIKE', "%{$searchTerm}%")
              ->orWhere('content_ar', 'LIKE', "%{$searchTerm}%")
              ->orWhereJsonContains('tags', $searchTerm)
              ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                  $categoryQuery->where('name_ar', 'LIKE', "%{$searchTerm}%")
                               ->orWhere('name', 'LIKE', "%{$searchTerm}%");
              });
        });
    }

    public function getFormattedDateAttribute(): string
    {
        if (!$this->published_at) {
            return '';
        }
        
        return \App\Services\DateFormatterService::formatDate($this->published_at);
    }

    /**
     * Record a unique view for this article
     * 
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @param string|null $sessionId
     * @return bool True if view was recorded (unique), false if already viewed recently
     */
    public function recordUniqueView(?string $ipAddress = null, ?string $userAgent = null, ?string $sessionId = null): bool
    {
        // Get IP address if not provided
        if (!$ipAddress) {
            $ipAddress = request()->ip();
        }
        
        // Get user agent if not provided
        if (!$userAgent) {
            $userAgent = request()->header('User-Agent');
        }
        
        // Get session ID if not provided
        if (!$sessionId) {
            $sessionId = session()->getId();
        }
        
        // Record the view if it's unique
        $viewRecorded = ArticleView::recordView($this->id, $ipAddress, $userAgent, $sessionId);
        
        // If a new view was recorded, update the views count
        if ($viewRecorded) {
            $this->updateViewsCount();
            return true;
        }
        
        return false;
    }

    /**
     * Update the views count based on unique views
     */
    public function updateViewsCount(): void
    {
        $uniqueViewCount = ArticleView::getUniqueViewCount($this->id);
        $this->update(['views' => $uniqueViewCount]);
    }

    /**
     * @deprecated Use recordUniqueView() instead
     */
    public function incrementViews(): void
    {
        // For backward compatibility, record a unique view
        $this->recordUniqueView();
    }

    /**
     * Get unique views for a specific time period
     * 
     * @param int|null $days Number of days to count (null for all time)
     * @return int
     */
    public function getUniqueViews(?int $days = null): int
    {
        return ArticleView::getUniqueViewCount($this->id, $days);
    }

    /**
     * Get localized title based on current locale
     */
    public function getLocalizedTitle(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'ar') {
            return $this->title_ar ?: $this->title_en ?: $this->title ?: 'Untitled';
        }
        return $this->title_en ?: $this->title ?: 'Untitled';
    }

    /**
     * Get localized description based on current locale
     */
    public function getLocalizedDescription(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'ar') {
            return $this->description_ar ?: $this->description_en ?: $this->description ?: 'No description available';
        }
        return $this->description_en ?: $this->description ?: 'No description available';
    }

    /**
     * Get localized content based on current locale
     */
    public function getLocalizedContent(): string
    {
        $locale = app()->getLocale();
        $content = '';
        
        if ($locale === 'ar') {
            $content = $this->content_ar ?: $this->content_en ?: $this->content ?: 'No content available';
        } else {
            $content = $this->content_en ?: $this->content ?: 'No content available';
        }
        
        // Only convert line breaks if content has no HTML structure
        if ($content && $content !== 'No content available') {
            // If content is plain text (no HTML tags), convert line breaks
            if (!preg_match('/<[^>]*>/', $content)) {
                $content = nl2br($content);
            }
        }
        
        return $content;
    }

    // Series Relationships
    public function series()
    {
        return $this->belongsTo(Article::class, 'series_id');
    }

    public function seriesArticles()
    {
        return $this->hasMany(Article::class, 'series_id')->orderBy('series_order');
    }

    // Prerequisites Relationships
    public function prerequisites()
    {
        return $this->belongsToMany(Article::class, 'article_prerequisites', 'article_id', 'prerequisite_id');
    }

    // Related Articles
    public function relatedArticles()
    {
        return $this->belongsToMany(Article::class, 'related_articles', 'article_id', 'related_article_id');
    }

    // Helper Methods
    public function getNextArticle()
    {
        if (!$this->series_id) return null;
        return $this->series->seriesArticles()
            ->where('series_order', '>', $this->series_order)
            ->orderBy('series_order')
            ->first();
    }

    public function getPreviousArticle()
    {
        if (!$this->series_id) return null;
        return $this->series->seriesArticles()
            ->where('series_order', '<', $this->series_order)
            ->orderBy('series_order', 'desc')
            ->first();
    }

    public function getLocalizedPrerequisites()
    {
        return app()->getLocale() === 'ar' ? $this->prerequisites_ar : $this->prerequisites;
    }

    /**
     * Get the comparison tables for the article
     */
    public function comparisonTables()
    {
        return $this->hasMany(ComparisonTable::class)->orderBy('order');
    }
}

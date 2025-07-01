<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeSnippet extends Model
{
    protected $fillable = [
        'article_id',
        'title',
        'title_en',
        'title_ar',
        'language',
        'code',
        'description',
        'description_en',
        'description_ar',
        'order',
        'show_line_numbers',
        'filename',
        'content_after',
        'content_after_en',
        'content_after_ar'
    ];

    protected $casts = [
        'show_line_numbers' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the article that owns the code snippet
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get localized title based on current locale
     */
    public function getLocalizedTitle(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'ar') {
            return $this->title_ar ?: $this->title_en ?: $this->title ?: 'Code Example';
        }
        return $this->title_en ?: $this->title ?: 'Code Example';
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
     * Get localized content after the code snippet based on current locale
     */
    public function getLocalizedContentAfter(): ?string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'ar') {
            $content = $this->content_after_ar ?: $this->content_after_en ?: $this->content_after;
        } else {
            $content = $this->content_after_en ?: $this->content_after;
        }
        
        // Only convert line breaks if content has no HTML structure
        if ($content && !preg_match('/<[^>]*>/', $content)) {
            $content = nl2br($content);
        }
        
        return $content;
    }

    /**
     * Scope to order snippets by their order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the CSS classes for the code block
     */
    public function getCodeClasses(): string
    {
        // Map only the essential language names that differ from Prism.js identifiers
        $languageMap = [
            'html' => 'markup', // HTML is mapped to 'markup' in Prism.js
            'xml' => 'markup',  // XML is also mapped to 'markup' in Prism.js
            'text' => 'none'    // Plain text
        ];

        $prismLanguage = $languageMap[$this->language] ?? $this->language;
        $classes = "language-{$prismLanguage}";
        
        if ($this->show_line_numbers) {
            $classes .= ' line-numbers';
        }
        
        return $classes;
    }

    /**
     * Get formatted filename or default
     */
    public function getDisplayFilename(): ?string
    {
        return $this->filename;
    }
}

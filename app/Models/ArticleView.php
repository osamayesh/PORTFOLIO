<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ArticleView extends Model
{
    protected $fillable = [
        'article_id',
        'ip_address',
        'user_agent',
        'session_id',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Check if a view should be counted as unique
     * 
     * @param int $articleId
     * @param string $ipAddress
     * @param string|null $sessionId
     * @param int|null $uniqueHours How many hours to consider a view unique (uses config if null)
     * @return bool
     */
    public static function shouldCountView(int $articleId, string $ipAddress, ?string $sessionId = null, ?int $uniqueHours = null): bool
    {
        // Check if view tracking is enabled
        if (!config('app.view_tracking.enabled', true)) {
            return false;
        }

        $uniqueHours = $uniqueHours ?? config('app.view_tracking.unique_hours', 24);
        $cutoffTime = Carbon::now()->subHours($uniqueHours);
        
        $existingView = static::where('article_id', $articleId)
            ->where('ip_address', $ipAddress)
            ->when($sessionId, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->where('viewed_at', '>', $cutoffTime)
            ->first();

        return !$existingView;
    }

    /**
     * Record a new view
     * 
     * @param int $articleId
     * @param string $ipAddress
     * @param string|null $userAgent
     * @param string|null $sessionId
     * @return static|null
     */
    public static function recordView(int $articleId, string $ipAddress, ?string $userAgent = null, ?string $sessionId = null): ?static
    {
        if (!static::shouldCountView($articleId, $ipAddress, $sessionId)) {
            return null;
        }

        try {
            return static::create([
                'article_id' => $articleId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'session_id' => $sessionId,
                'viewed_at' => Carbon::now()
            ]);
        } catch (\Exception $e) {
            // Handle duplicate entries gracefully
            return null;
        }
    }

    /**
     * Get unique view count for an article
     * 
     * @param int $articleId
     * @param int $days Number of days to count (default: all time)
     * @return int
     */
    public static function getUniqueViewCount(int $articleId, ?int $days = null): int
    {
        $query = static::where('article_id', $articleId);
        
        if ($days) {
            $query->where('viewed_at', '>', Carbon::now()->subDays($days));
        }
        
        return $query->count();
    }

    /**
     * Clean up old view records
     * 
     * @param int $olderThanDays Remove records older than X days (default: 365)
     * @return int Number of deleted records
     */
    public static function cleanupOldViews(int $olderThanDays = 365): int
    {
        $cutoffDate = Carbon::now()->subDays($olderThanDays);
        
        return static::where('viewed_at', '<', $cutoffDate)->delete();
    }
}

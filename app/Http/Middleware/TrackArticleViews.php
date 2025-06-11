<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Article;

class TrackArticleViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track views for successful GET requests to article pages
        if ($this->shouldTrackView($request, $response)) {
            $this->trackView($request);
        }

        return $response;
    }

    /**
     * Determine if we should track this view
     */
    private function shouldTrackView(Request $request, Response $response): bool
    {
        // Check if view tracking is globally enabled
        if (!config('app.view_tracking.enabled', true)) {
            return false;
        }

        // Only track GET requests
        if (!$request->isMethod('GET')) {
            return false;
        }

        // Only track successful responses
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        // Check if this is an article route
        if (!$request->route() || $request->route()->getName() !== 'articles.show') {
            return false;
        }

        // Skip bots and crawlers unless configured to track them
        if (!config('app.view_tracking.track_bots', false) && $this->isBot($request)) {
            return false;
        }

        // Skip prefetch requests
        if ($request->header('X-Purpose') === 'prefetch' || 
            $request->header('Purpose') === 'prefetch') {
            return false;
        }

        return true;
    }

    /**
     * Track the article view
     */
    private function trackView(Request $request): void
    {
        try {
            $slug = $request->route('slug');
            
            if ($slug) {
                $article = Article::published()->where('slug', $slug)->first();
                
                if ($article) {
                    $article->recordUniqueView(
                        $request->ip(),
                        $request->header('User-Agent'),
                        session()->getId()
                    );
                }
            }
        } catch (\Exception $e) {
            // Silently fail to avoid breaking the user experience
            \Log::warning('Failed to track article view: ' . $e->getMessage());
        }
    }

    /**
     * Check if the request is from a bot or crawler
     */
    private function isBot(Request $request): bool
    {
        $userAgent = strtolower($request->header('User-Agent', ''));
        
        $botPatterns = [
            'bot',
            'crawler',
            'spider',
            'crawling',
            'facebookexternalhit',
            'twitterbot',
            'whatsapp',
            'telegram',
            'googlebot',
            'bingbot',
            'slurp',
            'duckduckbot',
            'baiduspider',
            'yandexbot',
            'wget',
            'curl',
            'postman',
            'insomnia',
            'test',
            'monitor',
            'uptime',
            'pingdom',
            'gtmetrix',
            'pagespeed',
            'lighthouse'
        ];

        foreach ($botPatterns as $pattern) {
            if (str_contains($userAgent, $pattern)) {
                return true;
            }
        }

        return false;
    }
}

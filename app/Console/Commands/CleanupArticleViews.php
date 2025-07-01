<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\ArticleView;

class CleanupArticleViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:cleanup-views 
                            {--days= : Remove view records older than X days (default from config)} 
                            {--update-counts : Update view counts for all articles}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old article view records and optionally update view counts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days') ? (int) $this->option('days') : config('app.view_tracking.cleanup_days', 365);
        $updateCounts = $this->option('update-counts');

        $this->info("Starting article views cleanup...");

        // Clean up old records
        $this->info("Cleaning up view records older than {$days} days...");
        $deletedCount = ArticleView::cleanupOldViews($days);
        $this->info("Deleted {$deletedCount} old view records.");

        // Update view counts if requested
        if ($updateCounts) {
            $this->info("Updating view counts for all articles...");
            $articles = Article::all();
            $progressBar = $this->output->createProgressBar($articles->count());
            $progressBar->start();

            foreach ($articles as $article) {
                $article->updateViewsCount();
                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine();
            $this->info("Updated view counts for {$articles->count()} articles.");
        }

        $this->info("Article views cleanup completed!");
        
        return 0;
    }
}

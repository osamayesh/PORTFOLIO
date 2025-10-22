<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\ArticleView;

class UpdateArticleViewCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:update-view-counts {--article=* : Specific article IDs to update}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update article view counts based on unique views in article_views table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update article view counts...');
        
        $articleIds = $this->option('article');
        
        if (!empty($articleIds)) {
            // Update specific articles
            $articles = Article::whereIn('id', $articleIds)->get();
            $this->info('Updating ' . count($articles) . ' specific article(s)...');
        } else {
            // Update all articles
            $articles = Article::all();
            $this->info('Updating all articles...');
        }
        
        $progressBar = $this->output->createProgressBar(count($articles));
        $progressBar->start();
        
        $updated = 0;
        
        foreach ($articles as $article) {
            $oldCount = $article->views;
            $article->updateViewsCount();
            $newCount = $article->fresh()->views;
            
            if ($oldCount != $newCount) {
                $updated++;
                $this->newLine();
                $this->comment("Article #{$article->id}: {$oldCount} → {$newCount} views");
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        
        $this->newLine(2);
        $this->info("✓ View counts updated successfully!");
        $this->info("Total articles processed: " . count($articles));
        $this->info("Articles updated: {$updated}");
        
        return Command::SUCCESS;
    }
}

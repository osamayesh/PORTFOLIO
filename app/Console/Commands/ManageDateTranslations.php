<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DateTranslation;
use App\Services\DateFormatterService;

class ManageDateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'date:manage {action : Action to perform (clear-cache, refresh, list)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage date translations (clear cache, refresh, list)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'clear-cache':
                $this->clearCache();
                break;
            
            case 'refresh':
                $this->refreshTranslations();
                break;
                
            case 'list':
                $this->listTranslations();
                break;
                
            default:
                $this->error('Invalid action. Use: clear-cache, refresh, or list');
                return 1;
        }

        return 0;
    }

    /**
     * Clear date translations cache
     */
    private function clearCache()
    {
        DateFormatterService::clearCache();
        $this->info('Date translations cache cleared successfully!');
    }

    /**
     * Refresh translations by clearing cache and running seeder
     */
    private function refreshTranslations()
    {
        $this->info('Refreshing date translations...');
        
        // Clear cache
        DateFormatterService::clearCache();
        
        // Run seeder
        $this->call('db:seed', ['--class' => 'DateTranslationSeeder']);
        
        $this->info('Date translations refreshed successfully!');
    }

    /**
     * List all date translations
     */
    private function listTranslations()
    {
        $translations = DateTranslation::orderBy('type')
            ->orderBy('locale')
            ->orderBy('order_number')
            ->get();

        $this->table(
            ['ID', 'Type', 'Key', 'Locale', 'Value', 'Order'],
            $translations->map(function ($translation) {
                return [
                    $translation->id,
                    $translation->type,
                    $translation->key,
                    $translation->locale,
                    $translation->value,
                    $translation->order_number
                ];
            })->toArray()
        );
    }
}

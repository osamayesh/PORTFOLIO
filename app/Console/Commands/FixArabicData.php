<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Summary;

class FixArabicData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:arabic-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix corrupted Arabic data in summaries table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for corrupted Arabic data...');
        
        $summaries = Summary::all();
        $corrupted = [];
        
        foreach ($summaries as $summary) {
            // Check if Arabic fields contain question marks (corrupted data)
            if (str_contains($summary->title_ar, '?') || str_contains($summary->description_ar, '?')) {
                $corrupted[] = $summary;
                $this->warn("Found corrupted data in Summary ID: {$summary->id}");
                $this->line("Title AR: {$summary->title_ar}");
                $this->line("Description AR: {$summary->description_ar}");
                $this->line("---");
            }
        }
        
        if (empty($corrupted)) {
            $this->info('No corrupted Arabic data found!');
        } else {
            $this->error("Found " . count($corrupted) . " summaries with corrupted Arabic data.");
            $this->info("You will need to manually update these records with the correct Arabic text.");
            $this->info("You can use: php artisan tinker");
            $this->info("Then: \$summary = Summary::find(ID); \$summary->title_ar = 'correct arabic text'; \$summary->save();");
        }
        
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Summary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportPDFSummaries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summaries:import {--file= : Specific file to import} {--auto : Auto-detect and import all PDFs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import PDF files from storage to summaries database';

    /**
     * Available categories for summaries
     */
    protected $categories = [
        'api' => 'API World',
        'git' => 'Git and Version Control', 
        'advanced' => 'Advanced Programming',
        'books' => 'Books',
        'courses' => 'Courses',
        'documentation' => 'Documentation',
        'research' => 'Research',
        'interview' => 'Interview Questions'
    ];

    /**
     * Available color schemes
     */
    protected $colorSchemes = [
        'blue' => 'Blue Theme',
        'green' => 'Green Theme',
        'purple' => 'Purple Theme',
        'orange' => 'Orange Theme',
        'red' => 'Red Theme',
        'yellow' => 'Yellow Theme',
        'pink' => 'Pink Theme',
        'indigo' => 'Indigo Theme'
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📚 PDF Summaries Import Tool');
        $this->line('================================');

        // Check if pdfs directory exists
        if (!Storage::disk('public')->exists('pdfs')) {
            Storage::disk('public')->makeDirectory('pdfs');
            $this->info('Created pdfs directory in storage/app/public/');
        }

        // Get all PDF files from storage/app/public/pdfs
        $pdfFiles = Storage::disk('public')->files('pdfs');
        $pdfFiles = array_filter($pdfFiles, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
        });

        if (empty($pdfFiles)) {
            $this->warn('No PDF files found in storage/app/public/pdfs/');
            $this->info('Please copy your PDF files to: ' . storage_path('app/public/pdfs/'));
            return;
        }

        // Get existing summaries to avoid duplicates
        $existingFiles = Summary::pluck('pdf_file_path')->toArray();

        // Filter out already imported files
        $newFiles = array_filter($pdfFiles, function($file) use ($existingFiles) {
            return !in_array(basename($file), $existingFiles);
        });

        if (empty($newFiles)) {
            $this->info('All PDF files have already been imported!');
            return;
        }

        $this->info('Found ' . count($newFiles) . ' new PDF files to import:');
        foreach ($newFiles as $file) {
            $this->line('  • ' . basename($file));
        }
        $this->line('');

        if ($this->option('auto')) {
            $this->autoImportFiles($newFiles);
        } else {
            $this->interactiveImport($newFiles);
        }
    }

    /**
     * Auto import files with basic naming convention
     */
    protected function autoImportFiles($files)
    {
        $this->info('🚀 Auto-importing files...');
        
        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            
            // Try to detect category from filename
            $category = $this->detectCategory($filename);
            
            $summary = Summary::create([
                'title_en' => $this->generateTitle($filename, 'en'),
                'title_ar' => $this->generateTitle($filename, 'ar'), 
                'description_en' => "Summary document for {$filename}",
                'description_ar' => "ملخص وثيقة لـ {$filename}",
                'category' => $category,
                'pdf_file_path' => basename($file),
                'color_scheme' => $this->getRandomColorScheme(),
                'published_date' => now(),
                'is_active' => true,
                'sort_order' => Summary::max('sort_order') + 1
            ]);

            $this->info("✅ Imported: {$filename} → Category: {$category}");
        }

        $this->info('🎉 Auto-import completed!');
    }

    /**
     * Interactive import with user input
     */
    protected function interactiveImport($files)
    {
        $this->info('🎯 Interactive import mode');
        $this->line('You will be prompted for details for each file.');
        $this->line('');

        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            
            $this->info("📄 Importing: {$filename}");
            $this->line('---');

            // Get titles
            $titleEn = $this->ask('English title', $this->generateTitle($filename, 'en'));
            $titleAr = $this->ask('Arabic title (العنوان بالعربي)', $this->generateTitle($filename, 'ar'));

            // Get descriptions  
            $descEn = $this->ask('English description', "Summary document covering key concepts and insights from {$filename}");
            $descAr = $this->ask('Arabic description (الوصف بالعربي)', "ملخص شامل يغطي المفاهيم والأفكار الرئيسية من {$filename}");

            // Select category
            $this->line('Available categories:');
            foreach ($this->categories as $key => $name) {
                $this->line("  {$key} → {$name}");
            }
            $category = $this->choice('Select category', array_keys($this->categories), $this->detectCategory($filename));

            // Select color scheme
            $this->line('Available color schemes:');
            foreach ($this->colorSchemes as $key => $name) {
                $this->line("  {$key} → {$name}");
            }
            $colorScheme = $this->choice('Select color scheme', array_keys($this->colorSchemes), 'blue');

            // Create summary
            $summary = Summary::create([
                'title_en' => $titleEn,
                'title_ar' => $titleAr,
                'description_en' => $descEn,
                'description_ar' => $descAr,
                'category' => $category,
                'pdf_file_path' => basename($file),
                'color_scheme' => $colorScheme,
                'published_date' => now(),
                'is_active' => true,
                'sort_order' => Summary::max('sort_order') + 1
            ]);

            $this->info("✅ Successfully imported: {$titleEn}");
            $this->line('');
        }

        $this->info('🎉 Interactive import completed!');
    }

    /**
     * Detect category from filename
     */
    protected function detectCategory($filename)
    {
        $filename = strtolower($filename);
        
        if (str_contains($filename, 'api')) return 'api';
        if (str_contains($filename, 'git')) return 'git';
        if (str_contains($filename, 'book')) return 'books';
        if (str_contains($filename, 'course')) return 'courses';
        if (str_contains($filename, 'doc')) return 'documentation';
        if (str_contains($filename, 'research')) return 'research';
        if (str_contains($filename, 'advanced')) return 'advanced';
        if (str_contains($filename, 'interview')) return 'interview';
        
        return 'documentation'; // default
    }

    /**
     * Generate title from filename
     */
    protected function generateTitle($filename, $locale = 'en')
    {
        // Clean filename
        $title = str_replace(['_', '-'], ' ', $filename);
        $title = Str::title($title);
        
        if ($locale === 'ar') {
            // Simple Arabic title generation
            return "ملخص " . $title;
        }
        
        return $title;
    }

    /**
     * Get random color scheme
     */
    protected function getRandomColorScheme()
    {
        return array_rand($this->colorSchemes);
    }
}

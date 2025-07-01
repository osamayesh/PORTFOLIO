<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add bilingual title fields
            $table->string('title_en')->after('slug')->nullable();
            $table->string('title_ar')->after('title_en')->nullable();
            
            // Add bilingual description fields
            $table->text('description_en')->after('description')->nullable();
            $table->text('description_ar')->after('description_en')->nullable();
            
            // Add bilingual content fields
            $table->longText('content_en')->after('content')->nullable();
            $table->longText('content_ar')->after('content_en')->nullable();
        });
        
        // Copy existing data to English fields
        DB::statement('UPDATE articles SET title_en = title WHERE title_en IS NULL');
        DB::statement('UPDATE articles SET description_en = description WHERE description_en IS NULL');
        DB::statement('UPDATE articles SET content_en = content WHERE content_en IS NULL');
        
        // Set default Arabic content (you can update these later)
        DB::statement("UPDATE articles SET title_ar = CONCAT(title_en, ' (عربي)') WHERE title_ar IS NULL");
        DB::statement("UPDATE articles SET description_ar = CONCAT(description_en, ' (وصف عربي)') WHERE description_ar IS NULL");
        DB::statement("UPDATE articles SET content_ar = CONCAT(content_en, ' (محتوى عربي)') WHERE content_ar IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'title_en',
                'title_ar', 
                'description_en',
                'description_ar',
                'content_en',
                'content_ar'
            ]);
        });
    }
};

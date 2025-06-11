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
        // Fix the charset and collation for the summaries table
        DB::statement('ALTER TABLE summaries CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        
        // Specifically fix the Arabic text columns
        DB::statement('ALTER TABLE summaries MODIFY title_ar VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE summaries MODIFY description_ar TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        
        // Also fix English columns for consistency
        DB::statement('ALTER TABLE summaries MODIFY title_en VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE summaries MODIFY description_en TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to default charset (not recommended)
        DB::statement('ALTER TABLE summaries CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }
};

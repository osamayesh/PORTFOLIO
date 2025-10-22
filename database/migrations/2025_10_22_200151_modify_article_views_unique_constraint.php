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
        // First, try to drop the old unique constraint if it exists
        try {
            Schema::table('article_views', function (Blueprint $table) {
                $table->dropUnique('unique_article_view');
            });
        } catch (\Exception $e) {
            // Constraint doesn't exist, continue
        }
        
        // Clean up duplicate entries - keep only the first view for each IP/article combination
        DB::statement('
            DELETE t1 FROM article_views t1
            INNER JOIN article_views t2 
            WHERE t1.id > t2.id 
            AND t1.article_id = t2.article_id 
            AND t1.ip_address = t2.ip_address
        ');
        
        // Now add the new unique constraint if it doesn't exist
        try {
            Schema::table('article_views', function (Blueprint $table) {
                $table->unique(['article_id', 'ip_address'], 'unique_article_ip_view');
            });
        } catch (\Exception $e) {
            // Constraint already exists, continue
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_views', function (Blueprint $table) {
            // Restore the old unique constraint
            $table->dropUnique('unique_article_ip_view');
            $table->unique(['article_id', 'ip_address', 'session_id'], 'unique_article_view');
        });
    }
};

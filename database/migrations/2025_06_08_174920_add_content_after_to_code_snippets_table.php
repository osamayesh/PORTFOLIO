<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('code_snippets', function (Blueprint $table) {
            $table->longText('content_after')->nullable()->after('filename');
            $table->longText('content_after_en')->nullable()->after('content_after');
            $table->longText('content_after_ar')->nullable()->after('content_after_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('code_snippets', function (Blueprint $table) {
            $table->dropColumn(['content_after', 'content_after_en', 'content_after_ar']);
        });
    }
};

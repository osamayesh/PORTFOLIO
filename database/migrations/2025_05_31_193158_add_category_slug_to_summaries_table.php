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
        Schema::table('summaries', function (Blueprint $table) {
            $table->string('category_slug')->nullable()->after('category');
            $table->foreign('category_slug')->references('slug')->on('summary_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('summaries', function (Blueprint $table) {
            $table->dropForeign(['category_slug']);
            $table->dropColumn('category_slug');
        });
    }
};

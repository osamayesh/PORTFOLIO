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
        Schema::create('date_translations', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'day' or 'month'
            $table->string('key'); // English key (e.g., 'Monday', 'January')
            $table->string('locale'); // Language code (e.g., 'ar', 'en')
            $table->string('value'); // Translated value
            $table->integer('order_number')->nullable(); // For ordering days/months
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['type', 'locale']);
            $table->index(['key', 'locale']);
            $table->unique(['type', 'key', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('date_translations');
    }
};

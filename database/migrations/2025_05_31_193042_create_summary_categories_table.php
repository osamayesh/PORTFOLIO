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
        Schema::create('summary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // English name
            $table->string('name_ar'); // Arabic name  
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('color')->default('blue'); // Color theme
            $table->text('icon')->nullable(); // SVG icon or icon class
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summary_categories');
    }
};

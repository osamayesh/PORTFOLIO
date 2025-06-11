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
        Schema::create('comparison_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            
            // Title fields
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            
            // Description fields
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            
            // Table data stored as JSON
            $table->json('table_data'); // Will store headers and rows
            $table->json('table_data_en')->nullable();
            $table->json('table_data_ar')->nullable();
            
            // Display options
            $table->integer('order')->default(0);
            $table->boolean('show_header')->default(true);
            $table->boolean('show_borders')->default(true);
            $table->boolean('striped_rows')->default(true);
            $table->string('table_style')->default('default'); // default, compact, modern
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comparison_tables');
    }
};

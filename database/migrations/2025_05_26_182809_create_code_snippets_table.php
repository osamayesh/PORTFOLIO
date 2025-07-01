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
        Schema::create('code_snippets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable(); // Title for the code snippet
            $table->string('title_en')->nullable(); // English title
            $table->string('title_ar')->nullable(); // Arabic title
            $table->string('language')->default('text'); // Programming language (c, php, javascript, python, etc.)
            $table->text('code'); // The actual code content
            $table->text('description')->nullable(); // Optional description
            $table->text('description_en')->nullable(); // English description
            $table->text('description_ar')->nullable(); // Arabic description
            $table->integer('order')->default(0); // Order for multiple snippets in same article
            $table->boolean('show_line_numbers')->default(true); // Whether to show line numbers
            $table->string('filename')->nullable(); // Optional filename
            $table->timestamps();

            $table->index(['article_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_snippets');
    }
};

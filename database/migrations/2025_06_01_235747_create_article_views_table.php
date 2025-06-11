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
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45); // Support both IPv4 and IPv6
            $table->string('user_agent')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['article_id', 'ip_address']);
            $table->index(['article_id', 'session_id']);
            $table->index('viewed_at');
            
            // Ensure unique constraint for same IP viewing same article within timeframe
            $table->unique(['article_id', 'ip_address', 'session_id'], 'unique_article_view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};

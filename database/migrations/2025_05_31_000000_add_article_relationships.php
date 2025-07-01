<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArticleRelationships extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('series_id')->nullable()->constrained('articles');
            $table->integer('series_order')->nullable();
            $table->text('prerequisites')->nullable();
            $table->text('prerequisites_ar')->nullable();
            $table->string('programming_language')->nullable();
            $table->string('framework')->nullable();
        });

        Schema::create('article_prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('prerequisite_id')->constrained('articles')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('related_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('related_article_id')->constrained('articles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('related_articles');
        Schema::dropIfExists('article_prerequisites');
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['series_id', 'series_order', 'prerequisites', 'prerequisites_ar', 'programming_language', 'framework']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleArticleTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('article_article_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id', 'article_id_fk_2995560')->references('id')->on('articles')->onDelete('cascade');
            $table->unsignedBigInteger('article_tag_id');
            $table->foreign('article_tag_id', 'article_tag_id_fk_2995560')->references('id')->on('article_tags')->onDelete('cascade');
        });
    }
}

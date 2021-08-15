<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToArticleCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('article_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2995574')->references('id')->on('users');
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id', 'article_fk_2995580')->references('id')->on('articles');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToArticleLikesTable extends Migration
{
    public function up()
    {
        Schema::table('article_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_2995642')->references('id')->on('users');
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id', 'article_fk_2995643')->references('id')->on('articles');
        });
    }
}

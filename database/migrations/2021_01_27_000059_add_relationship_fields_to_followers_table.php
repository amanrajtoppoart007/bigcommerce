<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFollowersTable extends Migration
{
    public function up()
    {
        Schema::table('followers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_2995632')->references('id')->on('users');
            $table->unsignedBigInteger('follow_id');
            $table->foreign('follow_id', 'follow_fk_2995633')->references('id')->on('users');
        });
    }
}

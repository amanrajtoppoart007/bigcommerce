<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPincodesTable extends Migration
{
    public function up()
    {
        Schema::table('pincodes', function (Blueprint $table) {
            $table->unsignedBigInteger('block_id')->nullable();
            $table->foreign('block_id', 'block_fk_3052358')->references('id')->on('blocks');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2927119')->references('id')->on('users');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id', 'address_fk_2998788')->references('id')->on('user_addresses');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable();
//            $table->foreign('order_id', 'order_fk_2998604')->references('id')->on('orders');
            $table->unsignedBigInteger('user_id')->nullable();
//            $table->foreign('user_id', 'user_fk_2998605')->references('id')->on('users');
        });
    }
}

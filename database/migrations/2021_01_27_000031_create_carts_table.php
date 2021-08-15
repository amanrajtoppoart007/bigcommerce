<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit');
            $table->float('quantity', 15, 2);
            $table->float('amount', 15, 2)->nullable();
            $table->string('cart_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

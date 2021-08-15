<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('address')->nullable();
            $table->string('address_type')->nullable();
            $table->string('street')->nullable();
            $table->string('address_line_two')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

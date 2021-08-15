<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('transaction_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

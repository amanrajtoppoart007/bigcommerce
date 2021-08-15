<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchiseeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchisee_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('payment_type');
            $table->foreignId('franchisee_id')->constrained();
            $table->double('amount');
            $table->double('gst');
            $table->double('discount');
            $table->double('total_amount');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('franchisee_orders');
    }
}

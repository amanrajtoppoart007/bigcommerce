<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchiseeOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchisee_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchisee_order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('product_unit_id')->constrained();
            $table->unsignedSmallInteger('quantity');
            $table->double('price');
            $table->double('gst');
            $table->double('discount');
            $table->double('total_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('franchisee_order_items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('cart_number')->nullable();
            $table->string('unit')->nullable();
            $table->string('unit_quantity')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('help_center_id')->nullable()->constrained();
            $table->decimal('discount_amount')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
}

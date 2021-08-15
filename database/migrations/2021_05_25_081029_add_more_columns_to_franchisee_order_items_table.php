<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToFranchiseeOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('franchisee_order_items', function (Blueprint $table) {
            $table->string('unit')->nullable();
            $table->string('unit_quantity')->nullable();
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
        Schema::table('franchisee_order_items', function (Blueprint $table) {
            //
        });
    }
}

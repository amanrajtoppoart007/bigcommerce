<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentAndStockRelatedColumnsToFranchiseeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('franchisee_orders', function (Blueprint $table) {
            $table->boolean('is_invoice_generated')->default(false);
            $table->unsignedBigInteger('payment_verified_by')->nullable();
            $table->boolean('is_payment_verified')->default(false);
            $table->boolean('is_stock_updated')->default(false);
            $table->foreign('payment_verified_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('franchisee_orders', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->char('invoice_number', 15)->unique();
            $table->dateTime('date_time');
            $table->string('invoiceable_type');
            $table->unsignedBigInteger('invoiceable_id');
            $table->string('userable_type');
            $table->unsignedBigInteger('userable_id');
            $table->foreignId('transaction_id')->nullable();
            $table->string('payment_type');
            $table->decimal('amount')->default(0);
            $table->decimal('gst')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('total')->default(0);
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
        Schema::dropIfExists('invoices');
    }
}

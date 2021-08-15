<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_logistics', function (Blueprint $table) {
            $table->unsignedBigInteger("logistics_id");
            $table->unsignedBigInteger("role_id");
            $table->foreign('logistics_id', 'logistics_id_fk_001')->references('id')->on('logistics')->onDelete('cascade');
            $table->foreign('role_id', 'role_id_fk_0092')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_logistics');
    }
}

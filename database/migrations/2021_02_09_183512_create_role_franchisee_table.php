<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleFranchiseeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_franchisee', function (Blueprint $table) {
            $table->unsignedBigInteger("franchisee_id");
            $table->unsignedBigInteger("role_id");
            $table->foreign('franchisee_id', 'franchisee_id_fk_001')->references('id')->on('franchisees')->onDelete('cascade');
            $table->foreign('role_id', 'role_id_fk_0091')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_franchisee');
    }
}

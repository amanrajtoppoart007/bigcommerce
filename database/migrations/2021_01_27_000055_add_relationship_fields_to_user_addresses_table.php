<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_2998741')->references('id')->on('users');
            $table->unsignedBigInteger('pincode_id')->default(null)->nullable();
            $table->foreign('pincode_id', 'pincode_fk_2998742')->references('id')->on('pincodes');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id', 'district_fk_2998743')->references('id')->on('districts');
            $table->unsignedBigInteger('block_id')->nullable();
            $table->foreign('block_id', 'block_fk_2998744')->references('id')->on('blocks');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id', 'state_fk_2998745')->references('id')->on('states');
            $table->unsignedBigInteger('area_id')->default(null)->nullable();
            $table->foreign('area_id', 'area_fk_2998746')->references('id')->on('areas');
        });
    }
}

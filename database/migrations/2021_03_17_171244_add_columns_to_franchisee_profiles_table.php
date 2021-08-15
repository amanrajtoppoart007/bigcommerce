<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToFranchiseeProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('franchisee_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_pincode_id')->nullable();
            $table->unsignedBigInteger('representative_pincode_id')->nullable();
            $table->foreign('organization_pincode_id')->on('pincodes')->references('id');
            $table->foreign('representative_pincode_id')->on('pincodes')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('franchisee_profiles', function (Blueprint $table) {
            //
        });
    }
}

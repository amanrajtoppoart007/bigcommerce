<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFranchiseeProfilesTable extends Migration
{
    public function up()
    {
        Schema::table('franchisee_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_state_id')->nullable();
            $table->foreign('organization_state_id', 'organization_state_fk_3065219')->references('id')->on('states');
            $table->unsignedBigInteger('organization_district_id')->nullable();
            $table->foreign('organization_district_id', 'organization_district_fk_3065220')->references('id')->on('districts');
            $table->unsignedBigInteger('organization_city_id')->nullable();
            $table->foreign('organization_city_id', 'organization_city_fk_3065221')->references('id')->on('blocks');
            $table->unsignedBigInteger('representative_state_id')->nullable();
            $table->foreign('representative_state_id', 'representative_state_fk_3065226')->references('id')->on('states');
            $table->unsignedBigInteger('representative_district_id')->nullable();
            $table->foreign('representative_district_id', 'representative_district_fk_3065227')->references('id')->on('districts');
            $table->unsignedBigInteger('representative_city_id')->nullable();
            $table->foreign('representative_city_id', 'representative_city_fk_3065228')->references('id')->on('blocks');
            $table->unsignedBigInteger('franchisee_id');
            $table->foreign('franchisee_id', 'franchisee_fk_3065253')->references('id')->on('franchisees');
        });
    }
}

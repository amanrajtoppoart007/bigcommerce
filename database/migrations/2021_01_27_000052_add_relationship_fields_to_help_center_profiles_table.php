<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToHelpCenterProfilesTable extends Migration
{
    public function up()
    {
        Schema::table('help_center_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_state_id')->nullable();
            $table->foreign('organization_state_id', 'organization_state_fk_3065067')->references('id')->on('states');
            $table->unsignedBigInteger('organization_district_id')->nullable();
            $table->foreign('organization_district_id', 'organization_district_fk_3065068')->references('id')->on('districts');
            $table->unsignedBigInteger('organization_city_id')->nullable();
            $table->foreign('organization_city_id', 'organization_city_fk_3065069')->references('id')->on('blocks');
            $table->unsignedBigInteger('representative_state_id')->nullable();
            $table->foreign('representative_state_id', 'representative_state_fk_3065074')->references('id')->on('states');
            $table->unsignedBigInteger('representative_district_id')->nullable();
            $table->foreign('representative_district_id', 'representative_district_fk_3065075')->references('id')->on('districts');
            $table->unsignedBigInteger('representative_city_id')->nullable();
            $table->foreign('representative_city_id', 'representative_city_fk_3065076')->references('id')->on('blocks');
            $table->unsignedBigInteger('help_center_id');
            $table->foreign('help_center_id', 'help_center_fk_3065110')->references('id')->on('help_centers');
        });
    }
}

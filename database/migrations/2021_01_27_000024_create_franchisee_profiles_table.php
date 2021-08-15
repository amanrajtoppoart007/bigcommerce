<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchiseeProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('franchisee_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('organization_name')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('representative_name');
            $table->string('representative_designation')->nullable();
            $table->string('email')->nullable();
            $table->string('primary_contact');
            $table->string('secondary_contact')->nullable();
            $table->string('work_area')->nullable();
            $table->longText('organization_address')->nullable();
            $table->string('organization_street')->nullable();
            $table->string('organization_address_line_two')->nullable();
//            $table->integer('organization_pincode')->nullable();
            $table->longText('representative_address')->nullable();
            $table->string('representative_street')->nullable();
            $table->longText('representative_address_line_two')->nullable();
//            $table->integer('representative_pincode')->nullable();
            $table->decimal('registration_fees', 15, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEnquiriesTable extends Migration
{
    public function up()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('attendant_id')->nullable();
            $table->foreign('attendant_id', 'attendant_fk_3167399')->references('id')->on('admins');
        });
    }
}

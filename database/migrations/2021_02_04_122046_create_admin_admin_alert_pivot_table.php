<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAdminAlertPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_admin_alert', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_alert_id');
            $table->foreign('admin_alert_id', 'admin_alert_id_fk_2924387')->references('id')->on('user_alerts')->onDelete('cascade');
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id', 'admin_id_fk_2924387')->references('id')->on('admins')->onDelete('cascade');
            $table->boolean('read')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_admin_alert');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchiseesTable extends Migration
{
    public function up()
    {
        Schema::create('franchisees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('password');
            $table->datetime('email_verified_at')->nullable();
            $table->datetime('mobile_verified_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->string('mobile_verification_token')->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->boolean('verified')->default(0)->nullable();
            $table->timestamp('verified_at')->default(null)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

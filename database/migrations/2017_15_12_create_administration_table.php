<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministrationTable extends Migration
{
    public function up()
    {
        Schema::create('administration', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('login');
            $table->string('password');
            $table->string('email');
            $table->int('level');

        });
    }

    public function down()
    {
        Schema::drop('administration');
    }
}
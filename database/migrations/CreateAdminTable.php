<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    public function up()
    {
        Schema::create('admin', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('password_hash');
            $table->string('email');
            $table->int('level');
            
        });
    }
    
    public function down()
    {
        Schema::drop('admin');
    }
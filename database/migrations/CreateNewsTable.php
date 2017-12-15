<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function(Blueprint $table)
        {
            $table->increments('id')->primary();
            $table->string('url')->unique();
            $table->string('title')->index('title');
            $table->string('news_text');
            $table->timestamp('time');
            $table->string('img');
        });
    }

    public function down()
    {
        Schema::drop('news');
    }

}
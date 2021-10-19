<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDognamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */    public function up()
    {
        Schema::create('dognames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('propertyName', 75);
            $table->string('dogName', 25);

            $table->foreign('username')->references('username')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dognames');
    }
}

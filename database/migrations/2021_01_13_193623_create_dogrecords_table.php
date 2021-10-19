<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('huntID', 75);
            $table->string('dogName', 50);
            $table->string('downTime', 10);
            $table->string('upTime', 10);
            $table->integer('numCP');
            $table->integer('numSP');
            $table->integer('numWF');
            $table->integer('numUP');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dogrecords');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHuntrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huntrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('huntID', 75);
            $table->mediumInteger('groupSize');
            $table->smallInteger('numHarv');
            $table->smallInteger('numCrip');
            $table->float('X_Coord', 10, 6);
            $table->float('Y_Coord', 10, 6);
            $table->string('Comments', 250);
            $table->string('encType', 15);
            $table->string('encTime', 10);
            $table->string('DogPoint', 50);
            $table->string('DogBack', 50);
            $table->integer('ShotsFired');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huntrecords');
    }
}

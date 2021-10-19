<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirdinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('birdinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('huntID', 75);
            $table->string('sex', 6);
            $table->string('Age', 10);
            $table->integer('weight');
            $table->string('bandID', 15);
            $table->string('wingBand', 15);
            $table->string('frequency', 10);
            $table->integer('CoveyNum');
            $table->float('Y-Coord', 10, 6);
            $table->float('X_Coord', 10, 6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birdinfo');
    }
}

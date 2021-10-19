<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLitesummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('litesummary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('huntID', 75);
            $table->mediumInteger('coveysPointed');
            $table->mediumInteger('coveysShot');
            $table->mediumInteger('coveyRises');
            $table->mediumInteger('coveysSeen');
            $table->mediumInteger('unprodPoints');
            $table->mediumInteger('singlePoints');
            $table->mediumInteger('numHarv');
            $table->smallInteger('numCrip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('litesummary');
    }
}

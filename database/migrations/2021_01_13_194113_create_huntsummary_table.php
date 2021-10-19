<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHuntsummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huntsummary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('huntID', 75);
            $table->string('date', 10);
            $table->string('propertyName', 75);
            $table->string('huntCourse', 75);
            $table->string('HuntType', 25);
            $table->string('skyCover', 25);
            $table->string('temp', 25);
            $table->string('wind', 25);
            $table->string('precip', 25);
            $table->string('startTime', 10);
            $table->string('endTime', 10);
            $table->integer('stopTime');
            $table->smallInteger('minutesHunted');
            $table->smallInteger('numCP');
            $table->smallInteger('numSP');
            $table->smallInteger('numWF');
            $table->smallInteger('numUP');
            $table->smallInteger('numHarvested');
            $table->smallInteger('numCrippled');
            $table->smallInteger('shotsFired');
            $table->decimal('hoursHunted', 7, 2);
            $table->decimal('coveysMovedHour', 5, 2);
            $table->decimal('coveysPointedHour', 5, 2);
            $table->decimal('coveysShotHour', 5, 2);
            $table->text('comments');
            $table->timestamp('timeStamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huntsummary');
    }
}

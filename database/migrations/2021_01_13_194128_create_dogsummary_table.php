<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogsummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogsummary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('huntID', 75);
            $table->string('date', 10);
            $table->string('propertyName', 75);
            $table->string('huntCourse', 75);
            $table->string('HuntType', 25);
            $table->string('dogName', 25);
            $table->integer('groundTimeMins');
            $table->smallInteger('numCP');
            $table->smallInteger('numSP');
            $table->smallInteger('numWF');
            $table->smallInteger('numUP');
            $table->decimal('coveysMovedHour', 5, 2);
            $table->decimal('coveysPointedHour', 5, 2);
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
        Schema::dropIfExists('dogsummary');
    }
}

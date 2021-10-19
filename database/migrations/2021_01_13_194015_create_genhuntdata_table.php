<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenhuntdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genhuntdata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('huntID', 75);
            $table->string('propertyName', 75);
            $table->string('huntCourse', 75);
            $table->string('huntParty', 100);
            $table->string('HuntType', 25);
            $table->string('skyCover', 25);
            $table->string('temp', 25);
            $table->string('wind', 25);
            $table->string('precip', 25);
            $table->string('startTime', 10);
            $table->string('endTime', 10);
            $table->integer('stopTime');
            $table->string('huntDate', 10);
            $table->smallInteger('maHarv');
            $table->smallInteger('mjHarv');
            $table->smallInteger('faHarv');
            $table->smallInteger('fjHarv');
            $table->string('comments', 100);
            $table->timestamp('timeStamp', $precision = 0);
            $table->text('jsonString');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genhuntdata');
    }
}

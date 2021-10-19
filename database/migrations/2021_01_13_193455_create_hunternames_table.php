<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHunternamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hunternames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('propertyName', 75);
            $table->string('huntPartyName', 75);
            $table->string('hunterName', 50);

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
        Schema::dropIfExists('hunternames');
    }
}

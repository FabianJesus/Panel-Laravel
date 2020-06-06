<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //TODO:add      $table->dateTime('start'); $table->dateTime('ending'); and function need 
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('direction');
            $table->double('budget');
            $table->double('cost');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('works');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
    }
}

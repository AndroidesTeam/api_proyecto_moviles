<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Edificio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edificio', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('foto')->nullable();
            $table->string('referencia')->nullable();
            $table->string('area')->nullable();
            $table->unsignedInteger('id_campus');
            $table->foreign('id_campus')->references('id')->on('campus');
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
        //
    }
}

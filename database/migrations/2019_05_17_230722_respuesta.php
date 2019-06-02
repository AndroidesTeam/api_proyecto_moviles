<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Respuesta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_evaluacion');
            $table->unsignedInteger('id_pregunta');
            $table->integer('puntuacion');
            $table->timestamps();
            $table->foreign('id_evaluacion')->references('id')->on('evaluacion');
            $table->foreign('id_pregunta')->references('id')->on('pregunta');
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

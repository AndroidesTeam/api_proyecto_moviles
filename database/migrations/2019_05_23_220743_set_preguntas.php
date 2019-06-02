<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPreguntas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('puntuacion')->nullable()->change();
            $table->unsignedInteger('id_evaluacion');
            $table->unsignedInteger('id_pregunta');
            $table->foreign('id_evaluacion')->references('id')->on('evaluacion');
            $table->foreign('id_pregunta')->references('id')->on('pregunta');
        });

        Schema::table('pregunta', function (Blueprint $table) {
            $table->integer('puntuacion')->nullable()->change();
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambioLlaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('respuesta', function (Blueprint $table) {
            //$table->dropColumn('id_evaluacion');
        });

        Schema::table('pregunta', function (Blueprint $table) {
            $table->unsignedInteger('id_evaluacion');
            $table->foreign('id_evaluacion')->references('id')->on('evaluacion');
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambioLlaves1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('respuesta', function (Blueprint $table) {
            $table->dropForeign('respuesta_id_evaluacion_foreign');
            $table->dropColumn('id_evaluacion');
        });

        Schema::table('pregunta', function (Blueprint $table) {
            $table->unsignedInteger('id_evaluacion')->nullable()->change();
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

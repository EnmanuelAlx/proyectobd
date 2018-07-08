<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresadosVotantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresados_votantes', function (Blueprint $table) {
            $table->string('id_eleccion');
            $table->integer('cedula_egresado');
            $table->integer('voto');
            $table->primary(['id_eleccion', 'cedula_egresado']);
            $table->foreign('id_eleccion')->references('id')->on('proceso_elecciones')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('cedula_egresado')->references('id')->on('egresados')
                ->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('egresados_votantes');
    }
}

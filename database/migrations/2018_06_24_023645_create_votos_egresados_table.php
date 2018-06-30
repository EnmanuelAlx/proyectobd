<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotosEgresadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votos_egresados', function (Blueprint $table) {
            $table->string('id_eleccion');
            $table->integer('cedula_egresado');
            $table->integer('id_egresado_postulado');
            $table->primary(['id_eleccion', 'cedula_egresado', 'id_egresado_postulado']);;
            $table->foreign('id_egresado_postulado')->references('id')->on('egresados_postulados')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign(['id_eleccion', 'cedula_egresado'])->references(['id_eleccion', 'cedula_egresado'])->on('egresados_votantes')
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
        Schema::dropIfExists('votos_egresados');
    }
}

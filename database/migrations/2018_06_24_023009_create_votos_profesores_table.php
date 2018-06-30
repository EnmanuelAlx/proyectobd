<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotosProfesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votos_profesores', function (Blueprint $table) {
            $table->string('id_eleccion');
            $table->integer('cedula_profesor');
            $table->integer('id_profesor_postulado');
            $table->primary(['id_eleccion', 'cedula_profesor', 'id_profesor_postulado']);;
            $table->foreign('id_profesor_postulado')->references('id')->on('profesores_postulados')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign(['id_eleccion', 'cedula_profesor'])->references(['id_eleccion', 'cedula_profesor'])->on('profesores_votantes')
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
        Schema::dropIfExists('votos_profesores');
    }
}

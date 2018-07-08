<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesoresVotantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesores_votantes', function (Blueprint $table) {
            $table->string('id_eleccion');
            $table->integer('cedula_profesor');
            $table->integer('voto');
            $table->primary(['id_eleccion', 'cedula_profesor']);
            $table->foreign('id_eleccion')->references('id')->on('proceso_elecciones')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('cedula_profesor')->references('id')->on('profesores')
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
        Schema::dropIfExists('profesores_votantes');
    }
}

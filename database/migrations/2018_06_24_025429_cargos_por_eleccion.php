<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CargosPorEleccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos_por_elecciones', function (Blueprint $table) {
            $table->integer('id_cargos');
            $table->integer('id_escuelas');
            $table->string('id_eleccion');
            $table->primary(['id_cargos', 'id_escuelas', 'id_eleccion']);
            $table->foreign('id_cargos')->references('id')->on('cargos');
            $table->foreign('id_escuelas')->references('id')->on('escuelas');
            $table->foreign('id_eleccion')->references('id')->on('proceso_elecciones');
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
        Schema::dropIfExists('cargos_por_elecciones');
    }
}

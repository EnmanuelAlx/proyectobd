<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posee', function (Blueprint $table) {
            $table->integer('id_profesor_postulado');
            $table->integer('id_cargos');
            $table->string('id_eleccion');
            $table->integer('id_escuelas');
            $table->primary(['id_profesor_postulado', 'id_cargos', 'id_eleccion', 'id_escuelas']);
            $table->foreign('id_profesor_postulado')->references('id')->on('profesores_postulados')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign(['id_cargos', 'id_eleccion', 'id_escuelas'])->references(['id_cargos', 'id_eleccion', 'id_escuelas'])
                ->on('cargos_por_elecciones');
//            $table->foreign('id_cargos')->references('id_cargos')->on('cargos_por_elecciones')
//                ->onDelete('restrict')->onUpdate('cascade');
//            $table->foreign('id_eleccion')->references('id_eleccion')->on('cargos_por_elecciones')
//                ->onDelete('restrict')->onUpdate('cascade');
//            $table->foreign('id_escuelas')->references('id_escuelas')->on('cargos_por_elecciones')
//                ->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('posee', function (Blueprint $table) {
            //
        });
    }
}

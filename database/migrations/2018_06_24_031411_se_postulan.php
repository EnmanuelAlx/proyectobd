<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SePostulan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * foreign(['id_cargos', 'id_eleccion', 'id_escuelas'])
     */
    public function up()
    {
        Schema::create('se_postulan', function (Blueprint $table) {
            $table->integer('id_egresado_postulado');
            $table->integer('id_cargos');
            $table->string('id_eleccion');
            $table->integer('n_votos');
            $table->integer('id_escuelas');

            $table->primary(['id_egresado_postulado', 'id_cargos', 'id_eleccion', 'id_escuelas']);

            $table->foreign('id_egresado_postulado')->references('id')->on('egresados_postulados')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign(['id_cargos', 'id_eleccion', 'id_escuelas'])->references(['id_cargos', 'id_eleccion', 'id_escuelas'])
                ->on('cargos_por_elecciones');

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
        Schema::table('se_postulan', function (Blueprint $table) {
            //
        });
    }
}

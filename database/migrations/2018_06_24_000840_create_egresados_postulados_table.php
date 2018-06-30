<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresadosPostuladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresados_postulados', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_postulacion');
            $table->integer('cedula');
            $table->integer('n_votos');
            $table->integer('status');
            $table->foreign('cedula')->references('cedula')->on('egresados')
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
        Schema::dropIfExists('egresados_postulados');
    }
}

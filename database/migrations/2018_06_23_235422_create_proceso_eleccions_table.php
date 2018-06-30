<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesoEleccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_elecciones', function (Blueprint $table) {
            $table->string('id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_limite_postulacion');
            $table->date('fecha_limite_votacion');
            $table->primary('id');
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
        Schema::dropIfExists('proceso_elecciones');
    }
}

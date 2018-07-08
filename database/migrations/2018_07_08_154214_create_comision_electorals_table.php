<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionElectoralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_electoral', function (Blueprint $table) {
            $table->integer('cedula');
            $table->string('id_eleccion');
            $table->primary(['cedula', 'id_eleccion']);
            $table->foreign('cedula')->references('id')->on('usuarios')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_eleccion')->references('id')->on('proceso_elecciones')
                ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comision_electorals');
    }
}

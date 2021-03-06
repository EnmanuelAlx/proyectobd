<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresados', function (Blueprint $table) {
            $table->integer('id');
            $table->date('fecha_egreso');
            $table->string('estado');
            $table->string('pais');
            $table->string('foto');
            $table->foreign('id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('egresados');
    }
}

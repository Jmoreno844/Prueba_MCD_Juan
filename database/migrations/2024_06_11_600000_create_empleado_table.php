<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->unsignedBigInteger('idCargoFK');
            $table->date('fecha_ingreso');
            $table->unsignedBigInteger('IdMunicipioFK');
            $table->foreign('idCargoFK')->references('id')->on('cargos');
            $table->foreign('IdMunicipioFK')->references('id')->on('municipio');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleado');
    }
}

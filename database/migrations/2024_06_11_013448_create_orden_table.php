<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedBigInteger('IdEmpleadoFK');
            $table->unsignedBigInteger('idEstadoFK');
            $table->foreign('IdEmpleadoFK')->references('id')->on('empleado');
            $table->foreign('IdEstadoFK')->references('id')->on('estado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orden');
    }
}

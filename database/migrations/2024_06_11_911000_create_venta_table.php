<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->id();
            $table->date('Fecha');
            $table->unsignedBigInteger('IdEmpleadoFK');
            $table->unsignedBigInteger('IdClienteFK');
            $table->unsignedBigInteger('IdFormaPagoFK');
            $table->foreign('IdEmpleadoFK')->references('id')->on('empleado');
            $table->foreign('IdClienteFK')->references('id')->on('cliente');
            $table->foreign('IdFormaPagoFK')->references('id')->on('forma_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta');
    }
}

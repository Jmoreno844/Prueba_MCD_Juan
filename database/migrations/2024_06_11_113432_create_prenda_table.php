<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prenda', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 50);
            $table->double('ValorUnitCop');
            $table->double('ValorUnitUsd');
            $table->unsignedBigInteger('IdEstadoFK');
            $table->unsignedBigInteger('IdTipoProteccionFK');
            $table->unsignedBigInteger('IdGeneroFK');
            $table->string('Codigo', 50);
            $table->foreign('IdEstadoFK')->references('id')->on('estado');
            $table->foreign('IdTipoProteccionFK')->references('id')->on('tipo_proteccion');
            $table->foreign('IdGeneroFK')->references('id')->on('genero');
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
        Schema::dropIfExists('prenda');
    }
}

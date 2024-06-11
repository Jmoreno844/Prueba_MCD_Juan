<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleOrdenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_orden', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdOrdenFK');
            $table->unsignedBigInteger('IdPrendaFK');
            $table->integer('cantidad_requerida');
            $table->integer('cantidad_producir');
            $table->unsignedBigInteger('IdColorFK');
            $table->unsignedBigInteger('IdTallaFK');
            $table->integer('cantidad_producida');
            $table->unsignedBigInteger('IdEstadoFK');
            $table->foreign('IdOrdenFK')->references('id')->on('orden');
            $table->foreign('IdPrendaFK')->references('id')->on('prenda');
            $table->foreign('IdColorFK')->references('id')->on('color');
            $table->foreign('IdTallaFK')->references('id')->on('talla');
            $table->foreign('IdEstadoFK')->references('id')->on('estado');
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
        Schema::dropIfExists('detalle_orden');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumoPrendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo_prendas', function (Blueprint $table) {
            $table->unsignedBigInteger("IdInsumoFK");
            $table->unsignedBigInteger("IdPrendaFK");
            $table->integer("Cantidad");
            $table->foreign("IdInsumoFK")->references("id")->on("insumo");
            $table->foreign("IdPrendaFK")->references("id")->on("prenda");

            // Definir la clave primaria compuesta
            $table->primary(['IdInsumoFK', 'IdPrendaFK']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo_prendas');
    }
}

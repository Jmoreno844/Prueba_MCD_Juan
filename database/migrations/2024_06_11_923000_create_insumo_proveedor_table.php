<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumoProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo_proveedor', function (Blueprint $table) {
            $table->unsignedBigInteger("IdInsumoFK");
            $table->unsignedBigInteger("IdProveedorFK");
            $table->foreign("IdInsumoFK")->references("id")->on("insumo");
            $table->foreign("IdProveedorFK")->references("id")->on("proveedor");

            // Definir la clave primaria compuesta
            $table->primary(['IdInsumoFK', 'IdProveedorFK']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo_proveedor');
    }
}

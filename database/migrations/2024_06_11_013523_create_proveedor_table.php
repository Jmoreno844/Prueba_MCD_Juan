<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id();
            $table->string('NitProovedor', 50);
            $table->string('Nombre', 50);
            $table->unsignedBigInteger('IdTipoPersona');
            $table->unsignedBigInteger('IdMunicipioFK');
            $table->foreign('IdTipoPersona')->references('id')->on('tipo_persona');
            $table->foreign('IdMunicipioFK')->references('id')->on('municipio');
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
        Schema::dropIfExists('proveedor');
    }
}

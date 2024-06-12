<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('IdCliente', 50);
            $table->unsignedBigInteger('IdTipoPersonaFK');
            $table->date('fechaRegistro');
            $table->unsignedBigInteger('IdMunicipioFK');
            $table->foreign('IdTipoPersonaFK')->references('id')->on('tipo_persona');
            $table->foreign('IdMunicipioFK')->references('id')->on('municipio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('empresa', function (Blueprint $table) {
        $table->id();
        $table->string('nit', 50);
        $table->text('razon_social');
        $table->string('representante_legal', 50);
        $table->date('FechaCreacion');
        $table->unsignedBigInteger('IdMunicipioFK');
        $table->foreign('IdMunicipioFK')->references('id')->on('municipio');
    });
}

public function down()
{
    Schema::dropIfExists('empresa');
}
}

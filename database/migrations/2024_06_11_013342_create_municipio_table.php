<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->unsignedBigInteger('idDepartamentoFK');
            $table->foreign('idDepartamentoFK')->references('id')->on('departamento');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('municipio');
    }
}

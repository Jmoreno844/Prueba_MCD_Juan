<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('departamento', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 50);
        $table->unsignedBigInteger('IdPaisFK');
        $table->foreign('IdPaisFK')->references('id')->on('pais');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamento');
    }
}

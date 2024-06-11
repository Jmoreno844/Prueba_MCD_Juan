<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('tipo_persona', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 50);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('tipo_persona');
}
}

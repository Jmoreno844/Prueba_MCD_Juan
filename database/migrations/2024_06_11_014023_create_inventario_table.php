<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('CodInv', 255);
            $table->unsignedBigInteger("IdPrendaFK");
            $table->unsignedBigInteger("IdTallaFK");
            $table->unsignedBigInteger("IdColorFK");
            $table->integer('Cantidad');
            $table->foreign("IdPrendaFK")->references("id")->on("prenda");
            $table->foreign("IdTallaFK")->references("id")->on("talla");
            $table->foreign("IdColorFK")->references("id")->on("color");
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
        Schema::dropIfExists('inventario');
    }
}

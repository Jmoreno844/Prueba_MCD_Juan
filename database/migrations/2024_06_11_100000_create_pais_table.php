<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('pais', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 50);
    });
}

public function down()
{
    Schema::dropIfExists('pais');
}
}

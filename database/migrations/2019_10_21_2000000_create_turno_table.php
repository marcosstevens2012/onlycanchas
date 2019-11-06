<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turno', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('idcliente')->nullable();
            $table->string('fecha');
            $table->string('hora_inicio');
            $table->string('hora_fin');
            $table->string('user');
            $table->string('idcancha');
            $table->string('lote');
            $table->string('idestado');
            $table->string('turnofijo');
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
        Schema::dropIfExists('turno');
    }
}

<?php
// database/migrations/xxxx_xx_xx_create_reservas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id');
            $table->foreignId('id_libro')->constrained('libros', 'id');
            $table->date('fecha_reserva');
            $table->enum('estado_reserva', ['pendiente', 'completada', 'cancelada'])->default('pendiente');
            $table->timestamps();

            $table->index('id_libro');
            $table->index('id_usuario');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}

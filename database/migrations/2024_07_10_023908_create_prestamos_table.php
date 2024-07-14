<?php

// database/migrations/xxxx_xx_xx_create_prestamos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id');
            $table->foreignId('id_libro')->constrained('libros', 'id');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion')->nullable();
            $table->enum('estado', ['prestado', 'devuelto', 'cancelado'])->default('prestado');
            $table->timestamps();

            $table->index('id_libro');
            $table->index('id_usuario');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestamos');
    }
}
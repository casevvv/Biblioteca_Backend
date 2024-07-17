<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Route;


// Ruta para control libros
Route::get('/libros', [LibroController::class, 'mostrarLibros'])->name('mostrar_libros');
Route::post('/guardar-libro',  [LibroController::class, 'guardarLibro'])->name('guardar_libro');
Route::post('/actualizar-libro',  [LibroController::class, 'actualizarLibro'])->name('actualizar_libro');
Route::delete('/eliminar-libro',  [LibroController::class, 'eliminarLibro'])->name('eliminar_libro');

//Rutas para logica de prestamos y reservas
Route::post('/prestamo',[PrestamoController::class,'prestarLibro']);
Route::post('/reserva',[ReservaController::class,'reservarLibro'])->name('reservar_libro');
// Route::post('/devolver',[DevolverController::class,'devolverLibro'])->name('devolver_libro');

//Ruta para mostrar datos relevantes en el salpicadero
Route::get('/', [DashboardController::class, 'mostrarEstadisticas'])->name('mostrar_estadisticas');

//Rutas para control perfil de usuario  

//Ruta temporal para enviar solicitudes desde postman con el token en cada formulario
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});



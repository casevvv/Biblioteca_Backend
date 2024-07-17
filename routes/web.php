<?php

use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ReservaController;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Route;


// Ruta para la lista de libros

Route::post('/guardar-libro',  [LibroController::class, 'guardarLibro'])->name('guardar_libro');
Route::post('/actualizar-libro',  [LibroController::class, 'actualizarLibro'])->name('actualizar_libro');
Route::delete('/eliminar-libro',  [LibroController::class, 'eliminarLibro'])->name('eliminar_libro');
//Rutas para logica de prestamos y reservas
Route::post('/prestamo',[PrestamoController::class,'prestarLibro']);
Route::post('/reserva',[ReservaController::class,'reservarLibro'])->name('reservar_libro');
// Route::post('/devolver',[DevolverController::class,'devolverLibro'])->name('devolver_libro');
// Ruta en web.php


// Ruta para el dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Ruta para el perfil de usuario
Route::get('/profile', function () {
    return view('profileUser');
})->name('profile');

Route::get('/', [LibroController::class, 'show_all_book'])->name('show_all_book');


Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});



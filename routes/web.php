<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Rutas accesibles solo para invitados (usuarios no autenticados)
Route::middleware('guest')->group(function () {
    //Rutas para inicio/registro y cerrar sesion
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    
    Auth::routes();
    
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/libros', [LibroController::class, 'mostrarLibros'])->name('mostrar_libros');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta del dashboard (requiere autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard_client', [DashboardController::class, 'dashboard_client'])->name('dashboard_client');
    Route::get('/obtener-datos', [DashboardController::class, 'obtenerDatos']);

    //Rutas para logica de prestamos y reservas
    Route::post('/prestamo', [PrestamoController::class, 'prestarLibro']);
    Route::post('/reserva', [ReservaController::class, 'reservarLibro'])->name('reservar_libro');
    Route::post('/devolver', [PrestamoController::class, 'devolverLibro'])->name('devolver_libro');
    Route::post('/confirmar', [PrestamoController::class, 'confirmarReserva'])->name('confirmar_reserva');

    // Ruta para control libros
    Route::post('/guardar-libro',  [LibroController::class, 'guardarLibro'])->name('guardar_libro');
    Route::post('/actualizar-libro',  [LibroController::class, 'actualizarLibro'])->name('actualizar_libro');
    Route::delete('/eliminar-libro',  [LibroController::class, 'eliminarLibro'])->name('eliminar_libro');

    //Ruta de Usuarios
    Route::get('/Usuario', [UserController::class, 'mostrarUsers'])->name('mostrar_usuarios');
    Route::post('/guardar-usuario',  [UserController::class, 'guardarUser'])->name('guardar_user');
    Route::post('/actualizar-usuario',  [UserController::class, 'actualizarUser'])->name('actualizar_user');
    Route::delete('/eliminar-usuario',  [UserController::class, 'eliminarUser'])->name('eliminar_user');


    Route::get('/mostrar-perfil/{id}',  [UserController::class, 'mostrarPorId'])->name('mostrar_perfil');
    Route::post('/editar-perfil/{id}',  [UserController::class, 'editarPerfil'])->name('editar_perfil');
});

// //Ruta temporal para enviar solicitudes desde postman con el token en cada formulario
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

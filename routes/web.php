<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LibroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/',  [LibroController::class, 'show_all_book'])->name('show_all_book');
Route::post('/guardar-libro',  [LibroController::class, 'guardarLibro'])->name('guardar_libro');
Route::post('/actualizar-libro',  [LibroController::class, 'actualizarLibro'])->name('actualizar_libro');
Route::delete('/eliminar-libro',  [LibroController::class, 'eliminarLibro'])->name('eliminar_libro');

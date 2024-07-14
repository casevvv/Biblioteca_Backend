<?php

namespace App\Http\Controllers;

use App\Models\Categoria; // Importar el modelo Categoria
use Illuminate\Http\Request; // Importar el manejador de solicitudes HTTP

class CategoriaController extends Controller
{
    // Método para crear una nueva categoría
    public function add(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'nombre_categoria' => 'required|string|max:100',
        ]);

        // Crear una nueva categoría
        $categoria = new Categoria();
        $categoria->nombre_categoria = $request->nombre_categoria;
  
        $categoria->save();

        return response()->json(['message' => 'Categoria guardada correctamente']);
    }

    // Método para obtener todas las categorías
    public function show()
    {
        $categorias = Categoria::all();
        return view('libros')->with('categorias', $categorias);
    }
}

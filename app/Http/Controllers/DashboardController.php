<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Editorial;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Libros: Total de libros, libros por categoría, libros disponibles, libros prestados, libros más populares.
    // Autores: Autores más populares (basado en número de libros prestados o reservados).
    // Usuarios: Usuarios más activos (basados en número de préstamos o reservas).
    // Préstamos: Estadísticas de préstamos (número total, préstamos por mes, libros más prestados).
    // Reservas: Estadísticas de reservas (número total, reservas por mes, libros más reservados).


    // public function mostrarEstadisticas(Request $request)
    // {
    //     $categorias = Categoria::all();
    //     $autores = Autor::all();
    //     $editoriales = Editorial::all();
    //     $libros = Libro::with(['autor', 'editorial', 'categoria'])->get();
    //     // Añadiendo más estadísticas
    //     $totalLibros = $libros->count();
    //     $totalPrestamos = Prestamo::count();
    //     $librosDisponibles = $libros->where('estado', true)->count();
    //     $librosReservados = Reserva::where('estado', 'pendiente')->count();

    //     // Obtener usuarios relevantes (ejemplo: usuarios con más préstamos)
    //     $usuariosRelevantes = Usuario::withCount('prestamos')->orderBy('prestamos_count', 'desc')->take(5)->get();

    //     return view('dashboard')->with([
    //         'categorias' => $categorias,
    //         'autores' => $autores,
    //         'editoriales' => $editoriales,
    //         'libros' => $libros,
    //         'totalLibros' => $totalLibros,
    //         'totalPrestamos' => $totalPrestamos,
    //         'librosDisponibles' => $librosDisponibles,
    //         'librosReservados' => $librosReservados,
    //         'usuariosRelevantes' => $usuariosRelevantes
    //     ]);
    // }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function obtenerDatos(Request $request)
    {
        $filtro = $request->input('filtro');
        $datos = [];

        if (!$filtro || $filtro === 'libros-por-categoria') {
            $librosPorCategoria = Libro::select('categoria_id', DB::raw('count(*) as total'))
                ->groupBy('categoria_id')
                ->pluck('total', 'categoria_id');
            $datos['librosPorCategoria'] = [
                'labels' => $librosPorCategoria->keys(),
                'series' => [$librosPorCategoria->values()]
            ];
        }

        if (!$filtro || $filtro === 'libros-disponibles') {
            $librosDisponibles = Libro::where('estado', true)->count();
            $datos['librosDisponibles'] = [
                'labels' => ['Libros Disponibles'],
                'series' => [$librosDisponibles]
            ];
        }

        if (!$filtro || $filtro === 'libros-prestados') {
            $librosPrestados = Prestamo::count();
            $datos['librosPrestados'] = [
                'labels' => ['Libros Prestados'],
                'series' => [$librosPrestados]
            ];
        }

        if (!$filtro || $filtro === 'libros-mas-populares') {
            $librosMasPopulares = Libro::withCount('prestamos')
                ->orderBy('prestamos_count', 'desc')
                ->take(10)
                ->get(['titulo', 'prestamos_count']);
            $datos['librosMasPopulares'] = [
                'labels' => $librosMasPopulares->pluck('titulo'),
                'series' => [$librosMasPopulares->pluck('prestamos_count')]
            ];
        }

        if (!$filtro || $filtro === 'autores-mas-populares') {
            $autoresMasPopulares = Autor::withCount('libros')
                ->orderBy('libros_count', 'desc')
                ->take(10)
                ->get(['nombre', 'libros_count']);
            $datos['autoresMasPopulares'] = [
                'labels' => $autoresMasPopulares->pluck('nombre'),
                'series' => [$autoresMasPopulares->pluck('libros_count')]
            ];
        }

        if (!$filtro || $filtro === 'usuarios-mas-activos') {
            $usuariosMasActivos = User::withCount('prestamos')
                ->orderBy('prestamos_count', 'desc')
                ->take(10)
                ->get(['nombre', 'prestamos_count']);
            $datos['usuariosMasActivos'] = [
                'labels' => $usuariosMasActivos->pluck('nombre'),
                'series' => [$usuariosMasActivos->pluck('prestamos_count')]
            ];
        }

        if (!$filtro || $filtro === 'prestamos-por-mes') {
            $prestamosPorMes = Prestamo::select(DB::raw('EXTRACT(MONTH FROM fecha_prestamo) as mes'), DB::raw('count(*) as total'))
                ->groupBy('mes')
                ->pluck('total', 'mes');
            $datos['prestamosPorMes'] = [
                'labels' => $prestamosPorMes->keys(),
                'series' => [$prestamosPorMes->values()]
            ];
        }

        if (!$filtro || $filtro === 'reservas-por-mes') {
            $reservasPorMes = Reserva::select(DB::raw('EXTRACT(MONTH FROM fecha_reserva) as mes'), DB::raw('count(*) as total'))
                ->groupBy('mes')
                ->pluck('total', 'mes');
            $datos['reservasPorMes'] = [
                'labels' => $reservasPorMes->keys(),
                'series' => [$reservasPorMes->values()]
            ];
        }

        return response()->json($datos);
    }
}

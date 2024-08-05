<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\User;
use App\Models\Usuario;
use App\Notifications\LibroDisponible;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class PrestamoController extends Controller
{
    public function prestarLibro(Request $request)
    {
        try {
            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'id_usuario' => 'required|integer|exists:usuarios,id',
                'id_libro' => 'required|integer|exists:libros,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $usuario = User::findOrFail($request->id_usuario);
            $libro = Libro::findOrFail($request->id_libro);
            $total_libro = $libro->cantidad;

            $total_prestamo = Prestamo::where('id_usuario', $request->id_usuario)
                ->where('id_libro', $request->id_libro)
                ->where('estado', 'prestado')
                ->count();

            $buscar_prestamo = Prestamo::where('id_usuario', $request->id_usuario)
                ->where('id_libro', $request->id_libro)
                ->where('estado', 'prestado')
                ->first();


            Log::info('Total de libros encontrados: ' . $total_libro);
            Log::info('Total de préstamos encontrados: ' . $total_prestamo);

            $existencias = $total_libro - $total_prestamo;
            Log::info('Existencias   ' . $existencias);
            if ($existencias > 0) {
                if ($buscar_prestamo) {
                    return Response()->json(['message' => 'Ya tienes un prestamo de ese libro']);
                }
                // Crear el préstamo si hay unidades disponibles
                $prestamo = Prestamo::create(
                    [
                        'id_usuario' => $request->id_usuario,
                        'id_libro' => $request->id_libro,
                        'estado' => 'prestado',
                        'fecha_prestamo' => now(),
                        'fecha_devolucion' => now()->addDays(14) // Ejemplo de fecha de devolución a 14 días
                    ]
                );

                $fechaPrestamo = Carbon::parse($prestamo->fecha_prestamo);
                $fechaDevolver = Carbon::parse($prestamo->fecha_devolucion);

                // Enviar correo con contenido HTML
                Mail::send('emails.notificacion_prestamo', [
                    'usuario' => $usuario,
                    'libro' => $libro,
                    'fechaPrestamo' => $fechaPrestamo,
                    'fechaDevolver' => $fechaDevolver
                ], function ($message) use ($usuario) {
                    $message->to($usuario->email)
                        ->subject('Libro Prestado');
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Préstamo registrado correctamente',
                    'prestamo' => $prestamo
                ], 200);
            } else {
                $libro->estado = false;

                return response()->json([
                    'success' => false,
                    'message' => 'No hay unidades disponibles para el préstamo',
                ], 400);
            }
        } catch (Exception $e) {

            return Response()->json(['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function devolverLibro(Request $request)
    {
        try {
            $request->validate([
                'id_prestamo' => 'required|integer|exists:prestamos,id',
            ]);

            $prestamo = Prestamo::findOrFail($request->id_prestamo);
            $prestamo->estado = 'devuelto';
            $prestamo->fecha_devolucion = now();
            $prestamo->save();

            $libro = Libro::findOrFail($prestamo->id_libro);
            $libro->estado = true;
            $libro->save();

            // Procesar la primera reserva pendiente, si existe
            $reservaPendiente = Reserva::where('id_libro', $prestamo->id_libro)
                ->where('estado_reserva', 'pendiente')
                ->orderBy('fecha_reserva', 'asc')
                ->first();

            if ($reservaPendiente) {

                // Enviar notificación al usuario
                $usuario = User::findOrFail($reservaPendiente->id_usuario);
                $libro = Libro::findOrFail($prestamo->id_libro);

                // Llamar al método prestarLibro
                $request = new Request([
                    'id_usuario' => $usuario->id,
                    'id_libro' => $libro->id
                ]);

                $this->prestarLibro($request);

                // Actualizar el estado de la reserva a "notificado"
                $reservaPendiente->estado_reserva = 'completada';
                $reservaPendiente->save();

                return response()->json(['message' => 'Libro devuelto y notificación enviada al usuario para confirmar la reserva.'], 200);
            }

            return response()->json(['message' => 'Libro devuelto exitosamente.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    //     public function confirmarReserva(Request $request)
    //     {
    //         try {
    //             $request->validate([
    //                 'id' => 'required|integer|exists:reservas,id',
    //                 'accion' => 'required|in:confirmar,cancelar'
    //             ]);

    //             $reserva = Reserva::findOrFail($request->id);

    //             if ($request->accion === 'confirmar') {
    //                 // Crear el préstamo
    //                 $prestamo = Prestamo::create([
    //                     'id_usuario' => $reserva->id_usuario,
    //                     'id_libro' => $reserva->id_libro,
    //                     'estado' => 'prestado'
    //                 ]);

    //                 $usuario = Usuario::findOrFail($prestamo->id_usuario);
    //                 $libro = Libro::findOrFail($prestamo->id_libro);

    //                 $fechaPrestamo = Carbon::parse($prestamo->fecha_prestamo);
    //                 $fechaDevolver = Carbon::parse($prestamo->fecha_devolucion);

    //                 // Enviar correo con contenido HTML
    //                 Mail::send('emails.notificacion_prestamo', [
    //                     'usuario' => $usuario,
    //                     'libro' => $libro,
    //                     'fechaPrestamo' => $fechaPrestamo,
    //                     'fechaDevolver' => $fechaDevolver
    //                 ], function ($message) use ($usuario) {
    //                     $message->to($usuario->email)
    //                         ->subject('Libro Prestado');
    //                 });

    //                 // Actualizar el estado de la reserva a "completada"
    //                 $reserva->estado_reserva = 'completada';
    //                 $reserva->save();

    //                 return response()->json(['message' => 'Reserva confirmada y préstamo creado exitosamente.'], 200);
    //             } else {
    //                 // Actualizar el estado de la reserva a "cancelada"
    //                 $reserva->estado_reserva = 'cancelada';
    //                 $reserva->save();

    //                 // Procesar la siguiente reserva en la cola
    //                 $siguienteReserva = Reserva::where('id_libro', $reserva->id_libro)
    //                     ->where('estado_reserva', 'pendiente')
    //                     ->orderBy('fecha_reserva', 'asc')
    //                     ->first();

    //                 if ($siguienteReserva) {
    //                     // Enviar notificación al usuario
    //                     $usuario = Usuario::findOrFail($siguienteReserva->id_usuario);
    //                     $libro = Libro::findOrFail($siguienteReserva->id_libro);

    //                     $fechaReserva = Carbon::parse($siguienteReserva->fecha_reserva);

    //                     // Enviar correo con contenido HTML
    //                     Mail::send('emails.notificacion_reserva_disp', [
    //                         'usuario' => $usuario,
    //                         'libro' => $libro,
    //                         'reservaPendiente' => $siguienteReserva,
    //                         'fechaReserva' => $fechaReserva
    //                     ], function ($message) use ($usuario) {
    //                         $message->to($usuario->email)
    //                             ->subject('Libro Disponible');
    //                     });

    //                     $siguienteReserva->estado_reserva = 'notificado';
    //                     $siguienteReserva->save();
    //                 }

    //                 return response()->json(['message' => 'Reserva cancelada y siguiente reserva en la cola notificada.'], 200);
    //             }
    //         } catch (Exception $e) {
    //             Log::alert($e);
    //             return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    //         }
    //     }
}

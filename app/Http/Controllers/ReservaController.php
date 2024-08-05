<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\User;
use App\Models\Usuario;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReservaController extends Controller
{
    public function reservarLibro(Request $request)
    {
        try {
            $request->validate([
                'id_usuario' => 'required|integer|exists:usuarios,id',
                'id_libro' => 'required|integer|exists:libros,id'
            ]);

            $buscar_prestamo_previo = Prestamo::where('id_usuario', $request->id_usuario)
                ->where('id_libro', $request->id_libro)
                ->where('estado', 'prestado')
                ->first();

            if ($buscar_prestamo_previo) {
                return Response()->json(['message' => 'Ya tienes un prestamo de ese libro, quieres expandir el tiempo? habla con el bibliotecario']);
            }

            $buscar_reserva = Reserva::where('id_usuario', $request->id_usuario)
                ->where('id_libro', $request->id_libro)
                ->where('estado_reserva', 'pendiente')
                ->first();

            if ($buscar_reserva) {
                return response()->json(['message' => 'El usuario ya tiene una reserva pendiente de ese libro'], 400);
            }

            $crear_reserva = Reserva::create([
                'id_usuario' => $request->id_usuario,
                'id_libro' => $request->id_libro,
                'fecha_reserva' => now(),
                'fecha_confirm_reserva' => null,
                'estado_reserva' => 'pendiente'
            ]);

            // Enviar notificación al usuario
            $usuario = User::findOrFail($crear_reserva->id_usuario);
            $libro = Libro::findOrFail($crear_reserva->id_libro);

            // Enviar correo con contenido HTML
            Mail::send('emails.notificacion_reserva_creada', [
                'usuario' => $usuario,
                'libro' => $libro,
                'numeroReserva' => $crear_reserva,
                'fechaReserva' => $crear_reserva
            ], function ($message) use ($usuario) {
                $message->to($usuario->email)
                    ->subject('Libro Reservado');
            });

            return response()->json([
                'success' => true,
                'message' => 'Reservado correctamente',
                'reserva' => $crear_reserva
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function cancelarReserva(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:reservas,id',
                'accion' => 'required|in:confirmar,cancelar'
            ]);

            $reserva = Reserva::findOrFail($request->id);

            if ($request->accion === 'confirmar') {
                // Crear el préstamo
                $prestamo = Prestamo::create([
                    'id_usuario' => $reserva->id_usuario,
                    'id_libro' => $reserva->id_libro,
                    'estado' => 'prestado'
                ]);

                $usuario = User::findOrFail($prestamo->id_usuario);
                $libro = Libro::findOrFail($prestamo->id_libro);

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

                // Actualizar el estado de la reserva a "completada"
                $reserva->estado_reserva = 'completada';
                $reserva->save();

                return response()->json(['message' => 'Reserva confirmada y préstamo creado exitosamente.'], 200);
            } else {
                // Actualizar el estado de la reserva a "cancelada"
                $reserva->estado_reserva = 'cancelada';
                $reserva->save();

                // Procesar la siguiente reserva en la cola
                $siguienteReserva = Reserva::where('id_libro', $reserva->id_libro)
                    ->where('estado_reserva', 'pendiente')
                    ->orderBy('fecha_reserva', 'asc')
                    ->first();

                if ($siguienteReserva) {
                    // Enviar notificación al usuario
                    $usuario = User::findOrFail($siguienteReserva->id_usuario);
                    $libro = Libro::findOrFail($siguienteReserva->id_libro);

                    $fechaReserva = Carbon::parse($siguienteReserva->fecha_reserva);

                    // Enviar correo con contenido HTML
                    Mail::send('emails.notificacion_reserva_disp', [
                        'usuario' => $usuario,
                        'libro' => $libro,
                        'reservaPendiente' => $siguienteReserva,
                        'fechaReserva' => $fechaReserva
                    ], function ($message) use ($usuario) {
                        $message->to($usuario->email)
                            ->subject('Libro Disponible');
                    });

                    $siguienteReserva->estado_reserva = 'notificado';
                    $siguienteReserva->save();
                }

                return response()->json(['message' => 'Reserva cancelada y siguiente reserva en la cola notificada.'], 200);
            }
        } catch (Exception $e) {
            Log::alert($e);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}

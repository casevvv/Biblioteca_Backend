<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            color: #555555;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 12px;
            color: #777777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Hola, {{ $usuario->nombre }}!</h1>
        <p>El libro que reservaste ahora está en lista de espera:</p>
        <p><strong>Título del Libro:</strong> {{ $libro->titulo }}</p>
        <p><strong>Número de Reserva:</strong> {{ $numeroReserva->id }}</p>
        <p><strong>Fecha de Reserva:</strong> {{ $fechaReserva->fecha_reserva->format('d/m/Y') }}</p>
        <p>Gracias por usar nuestra biblioteca.</p>
        <div class="footer">
            &copy; {{ date('Y') }} Biblioteca. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id';

    public $timestamps = true; // Activar timestamps automáticos
    const CREATED_AT = 'fecha_reserva';
    const UPDATED_AT = null;

    protected $fillable = ['id_usuario', 'id_libro', 'estado_reserva'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'id_libro');
    }
}


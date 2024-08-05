<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id';

    public $timestamps = false; // timestamps automáticos

    protected $fillable = ['user_id', 'id_libro','fecha_reserva','estado_reserva'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'id_libro');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Si no usas created_at y updated_at

    protected $fillable = ['nombre', 'email', 'contrasena', 'tipo_usuario', 'google2fa_secret', 'codigoRec'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_usuario');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_usuario');
    }
}

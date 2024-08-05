<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';
    protected $fecha_prestamo = 'fecha_prestamo';
    protected $fecha_devolucion = 'fecha_devolucion';

    public $timestamps = false; // desactivar timestamps automáticos

    protected $fillable = ['user_id', 'id_libro', 'estado', 'fecha_prestamo','fecha_devolucion'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'id_libro');
    }
}

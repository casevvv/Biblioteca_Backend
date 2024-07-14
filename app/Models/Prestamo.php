<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';

    public $timestamps = true; // Activar timestamps automáticos
    const CREATED_AT = 'fecha_prestamo';
    const UPDATED_AT = 'fecha_devolucion';

    protected $fillable = ['id_usuario', 'id_libro', 'estado'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'id_libro');
    }
}

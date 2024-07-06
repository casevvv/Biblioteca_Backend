<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';
    protected $primaryKey = 'id_libro';
    public $timestamps = false; // Si no usas created_at y updated_at

    protected $fillable = ['titulo', 'autor', 'editorial', 'ano_publicacion', 'isbn', 'cantidad', 'id_categoria'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_libro');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_libro');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 'receta';
    public $timestamps = false;

    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'id_producto',
        'id_materia_prima',
        'cantidad_requerida',
    ];

    // Relaciones
    public function producto()
    {
        return $this->belongsTo(ProductoTerminado::class, 'id_producto', 'id_producto');
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'id_materia_prima', 'id_materia_prima');
    }
}

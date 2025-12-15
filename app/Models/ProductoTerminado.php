<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoTerminado extends Model
{
    protected $table = 'producto_terminado';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'descripcion', 'precio_venta',
        'stock_actual', 'stock_minimo', 'tiempo_preparacion'
    ];
}

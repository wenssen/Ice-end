<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePlanProducto extends Model
{
    protected $table = 'detalle_plan_producto';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_plan_produccion',
        'id_producto',
        'cantidad_a_producir',
    ];

    public function producto()
    {
        return $this->belongsTo(ProductoTerminado::class, 'id_producto', 'id_producto');
    }
}

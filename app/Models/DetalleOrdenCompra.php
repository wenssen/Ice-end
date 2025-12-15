<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrdenCompra extends Model
{
    protected $table = 'detalle_orden_compra';
    protected $primaryKey = 'id_detalle_orden_compra';
    public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'subtotal',
        'id_orden_compra',
        'id_materia_prima',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class, 'id_orden_compra', 'id_orden_compra');
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'id_materia_prima', 'id_materia_prima');
    }
}

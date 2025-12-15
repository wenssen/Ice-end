<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $table = 'orden_compra';
    protected $primaryKey = 'id_orden_compra';
    public $timestamps = false;

    protected $fillable = [
        'id_proveedor',
        'fecha',
        'estado',
        'total',
    ];

    protected $casts = [
        'fecha' => 'date',
        'total' => 'decimal:2',
    ];

    // Relación con proveedor (asumiendo que tu modelo Proveedor usa PK id_proveedor)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    // Relación con detalles (sin modelo, igual sirve si lo tienes)
    public function detalles()
    {
        return $this->hasMany(DetalleOrdenCompra::class, 'id_orden_compra', 'id_orden_compra');
        // Si NO tienes el modelo DetalleOrdenCompra, puedes borrar este método.
    }
}

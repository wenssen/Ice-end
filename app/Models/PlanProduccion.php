<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanProduccion extends Model
{
    protected $table = 'plan_produccion';
    protected $primaryKey = 'id_plan_produccion';
    public $timestamps = false;

    protected $fillable = [
        'fecha_plan',
        'fecha_ejecucion',
        'estado',
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePlanProducto::class, 'id_plan_produccion', 'id_plan_produccion');
    }
}

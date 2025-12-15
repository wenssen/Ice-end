<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    protected $table = 'materia_prima';
    protected $primaryKey = 'id_materia_prima';
    public $timestamps = false;

    protected $fillable = ['nombre','unidad_medida','stock_actual','stock_minimo','costo_unitario'];
}

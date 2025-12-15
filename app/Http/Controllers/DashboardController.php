<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener los últimos 5 planes de producción
        $plans = DB::table('plan_produccion')
                    ->orderBy('fecha_plan', 'desc')
                    ->limit(5)
                    ->get();

        // Obtener insumos con stock crítico (stock_actual <= stock_minimo)
        $criticalStock = DB::table('materia_prima')
                            ->whereColumn('stock_actual', '<=', 'stock_minimo')
                            ->get();

        // Pasar los datos a la vista
        return view('dashboard', compact('plans', 'criticalStock'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PlanProduccion;
use App\Models\DetallePlanProducto;
use App\Models\ProductoTerminado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanProduccionController extends Controller
{
    public function index()
    {
        // Obtener todos los planes de producción
        $planes = PlanProduccion::query()
            ->orderByDesc('id_plan_produccion')
            ->get();

        return view('produccion.index', compact('planes'));
    }

    public function show(PlanProduccion $plan)
    {
        // Cargar los detalles del plan y su producto asociado
        $plan->load(['detalles.producto']);
        return view('produccion.show', compact('plan'));
    }

    // Los siguientes métodos son solo para admin
    public function create()
    {
        $productos = ProductoTerminado::orderBy('nombre')->get();
        return view('produccion.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_plan' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id_producto' => ['required', 'integer', 'exists:producto_terminado,id_producto'],
            'items.*.cantidad' => ['required', 'numeric', 'min:1'],
        ]);

        DB::transaction(function () use ($request) {
            $plan = PlanProduccion::create([
                'fecha_plan' => $request->fecha_plan,
                'fecha_ejecucion' => null,
                'estado' => 'pendiente',
            ]);

            foreach ($request->items as $it) {
                DetallePlanProducto::create([
                    'id_plan_produccion' => $plan->id_plan_produccion,
                    'id_producto' => (int)$it['id_producto'],
                    'cantidad_a_producir' => (int)$it['cantidad'],
                ]);
            }
        });

        return redirect()->route('produccion.index')->with('success', 'Plan creado.');
    }

    public function edit(PlanProduccion $plan)
    {
        $plan->load(['detalles']);
        $productos = ProductoTerminado::orderBy('nombre')->get();

        return view('produccion.edit', compact('plan', 'productos'));
    }

    public function update(Request $request, PlanProduccion $plan)
    {
        $request->validate([
            'fecha_plan' => ['required', 'date'],
            'fecha_ejecucion' => ['nullable', 'date'],
            'estado' => ['required', 'in:pendiente,en_proceso,finalizado'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id_producto' => ['required', 'integer', 'exists:producto_terminado,id_producto'],
            'items.*.cantidad' => ['required', 'numeric', 'min:1'],
        ]);

        DB::transaction(function () use ($request, $plan) {
            $plan->update([
                'fecha_plan' => $request->fecha_plan,
                'fecha_ejecucion' => $request->fecha_ejecucion,
                'estado' => $request->estado,
            ]);

            DetallePlanProducto::where('id_plan_produccion', $plan->id_plan_produccion)->delete();

            foreach ($request->items as $it) {
                DetallePlanProducto::create([
                    'id_plan_produccion' => $plan->id_plan_produccion,
                    'id_producto' => (int)$it['id_producto'],
                    'cantidad_a_producir' => (int)$it['cantidad'],
                ]);
            }
        });

        return redirect()->route('produccion.index')->with('success', 'Plan actualizado.');
    }

    public function destroy(PlanProduccion $plan)
    {
        DB::transaction(function () use ($plan) {
            DetallePlanProducto::where('id_plan_produccion', $plan->id_plan_produccion)->delete();
            $plan->delete();
        });

        return redirect()->route('produccion.index')->with('success', 'Plan eliminado.');
    }

    public function cambiarEstado(Request $request, PlanProduccion $plan)
    {
        $request->validate([
            'estado' => ['required', 'in:pendiente,en_proceso,finalizado'], 
        ]);

        $data = ['estado' => $request->estado];

        if ($request->estado === 'en_proceso' && !$plan->fecha_ejecucion) {
            $data['fecha_ejecucion'] = now()->toDateString();
        }

        $plan->update($data);

        return back()->with('success', 'Estado actualizado.');
    }
}

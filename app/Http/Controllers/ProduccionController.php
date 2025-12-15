<?php

namespace App\Http\Controllers;

use App\Models\PlanProduccion;
use Illuminate\Http\Request;

class ProduccionController extends Controller
{
    public function index()
    {
        $planes = PlanProduccion::orderBy('id_plan_produccion','desc')->get();
        return view('produccion.index', compact('planes'));
    }

    public function create()
    {
        return view('produccion.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha'       => ['required','date'],
            'estado'      => ['required','string','max:30'],
            'observacion' => ['nullable','string','max:2000'],
        ]);

        PlanProduccion::create($data);

        return redirect()->route('produccion.index')->with('ok','Plan creado.');
    }

    public function edit($id)
    {
        $plan = PlanProduccion::findOrFail($id);
        return view('produccion.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = PlanProduccion::findOrFail($id);

        $data = $request->validate([
            'fecha'       => ['required','date'],
            'estado'      => ['required','string','max:30'],
            'observacion' => ['nullable','string','max:2000'],
        ]);

        $plan->update($data);

        return redirect()->route('produccion.index')->with('ok','Plan actualizado.');
    }

    public function destroy($id)
    {
        PlanProduccion::findOrFail($id)->delete();
        return redirect()->route('produccion.index')->with('ok','Plan eliminado.');
    }
}

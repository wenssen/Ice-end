<?php

namespace App\Http\Controllers;

use App\Models\MateriaPrima;
use Illuminate\Http\Request;

class MateriaPrimaController extends Controller
{
    public function index()
    {
        $materias = MateriaPrima::all();
        return view('materia_prima.index', compact('materias'));
    }

    public function create()
    {
        return view('materia_prima.create');
    }

    public function store(Request $request)
    {
        MateriaPrima::create($request->all());
        return redirect()->route('materias-primas.index');
    }

    public function edit($id)
    {
        $materia = MateriaPrima::findOrFail($id);
        return view('materia_prima.edit', compact('materia'));
    }

    public function update(Request $request, $id)
    {
        $materia = MateriaPrima::findOrFail($id);
        $materia->update($request->all());
        return redirect()->route('materias-primas.index');
    }

    public function destroy($id)
    {
        MateriaPrima::destroy($id);
        return redirect()->route('materias-primas.index');
    }

    public function alertas()
    {
        $criticos = MateriaPrima::whereColumn('stock_actual', '<=', 'stock_minimo')->get();
        return view('materia_prima.alertas', compact('criticos'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::orderBy('id_proveedor', 'desc')->get();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'   => ['required','string','max:120'],
            'rut'      => ['nullable','string','max:30'],
            'telefono' => ['nullable','string','max:30'],
            'email'    => ['nullable','email','max:120'],
            'estado'   => ['required','in:activo,inactivo'],
        ]);

        Proveedor::create($data);

        return redirect()->route('proveedores.index')->with('ok', 'Proveedor creado.');
    }

    /**
     * Ver proveedor + resumen de insumos comprados + historial de compras
     */
    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        // Compras (cabecera)
        $compras = DB::table('orden_compra')
            ->where('id_proveedor', $id)
            ->orderByDesc('id_orden_compra')
            ->get();

        // Insumos comprados a este proveedor (sumados)
        $insumos = DB::table('detalle_orden_compra as d')
            ->join('orden_compra as oc', 'oc.id_orden_compra', '=', 'd.id_orden_compra')
            ->join('materia_prima as mp', 'mp.id_materia_prima', '=', 'd.id_materia_prima')
            ->where('oc.id_proveedor', $id)
            ->selectRaw('
                mp.id_materia_prima,
                mp.nombre,
                mp.unidad_medida,
                SUM(d.cantidad) as cantidad_total,
                SUM(d.subtotal) as gasto_total
            ')
            ->groupBy('mp.id_materia_prima', 'mp.nombre', 'mp.unidad_medida')
            ->orderBy('mp.nombre')
            ->get();

        return view('proveedores.show', compact('proveedor', 'compras', 'insumos'));
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $data = $request->validate([
            'nombre'   => ['required','string','max:120'],
            'rut'      => ['nullable','string','max:30'],
            'telefono' => ['nullable','string','max:30'],
            'email'    => ['nullable','email','max:120'],
            'estado'   => ['required','in:activo,inactivo'],
        ]);

        $proveedor->update($data);

        return redirect()->route('proveedores.index')->with('ok', 'Proveedor actualizado.');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('ok', 'Proveedor eliminado.');
    }
}

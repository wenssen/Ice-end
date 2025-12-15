<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompra;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        // Cargamos proveedor para poder mostrar nombre en el index
        $compras = OrdenCompra::with('proveedor')
            ->orderBy('id_orden_compra', 'desc')
            ->get();

        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();

        // Lista de materias primas para el select de "insumo"
        $materias = DB::table('materia_prima')
            ->orderBy('nombre')
            ->get();

        return view('compras.create', compact('proveedores', 'materias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_proveedor' => ['required', 'integer', 'exists:proveedor,id_proveedor'],
            'fecha'        => ['required', 'date'],
            'estado'       => ['required', 'in:pendiente,recibida,cancelada'],

            // Array de insumos del form
            'insumos' => ['required', 'array', 'min:1'],
            'insumos.*.id' => ['required', 'integer', 'exists:materia_prima,id_materia_prima'],
            'insumos.*.cantidad' => ['required', 'numeric', 'min:0.01'],
            'insumos.*.precio_unitario' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($data) {

            // Total = suma subtotales
            $total = 0;
            foreach ($data['insumos'] as $i) {
                $total += ((float)$i['cantidad']) * ((float)$i['precio_unitario']);
            }
            $total = round($total, 2);

            // 1) Crear orden_compra
            $oc = OrdenCompra::create([
                'id_proveedor' => $data['id_proveedor'],
                'fecha'        => $data['fecha'],
                'estado'       => $data['estado'],
                'total'        => $total,
            ]);

            // 2) Insertar N detalles
            foreach ($data['insumos'] as $i) {
                $cantidad = (float) $i['cantidad'];
                $precio   = (float) $i['precio_unitario'];
                $subtotal = round($cantidad * $precio, 2);

                DB::table('detalle_orden_compra')->insert([
                    'cantidad'         => $cantidad,
                    'precio_unitario'  => $precio,
                    'subtotal'         => $subtotal,
                    'id_orden_compra'  => $oc->id_orden_compra,
                    'id_materia_prima' => $i['id'], // viene del form: insumos[*][id]
                ]);

                // 3) Si está recibida, actualiza stock
                if ($data['estado'] === 'recibida') {
                    DB::table('materia_prima')
                        ->where('id_materia_prima', $i['id'])
                        ->update([
                            'stock_actual' => DB::raw('stock_actual + ' . $cantidad),
                        ]);
                }
            }
        });

        return redirect()->route('compras.index')->with('ok', 'Compra creada.');
    }

    public function edit($id)
    {
        $compra = OrdenCompra::findOrFail($id);
        $proveedores = Proveedor::orderBy('nombre')->get();

        // Por si después quieres editar el insumo también:
        $materias = DB::table('materia_prima')
            ->orderBy('nombre')
            ->get();

        // Si quieres mostrar el detalle actual:
        $detalle = DB::table('detalle_orden_compra')
            ->where('id_orden_compra', $id)
            ->first();

        return view('compras.edit', compact('compra', 'proveedores', 'materias', 'detalle'));
    }

    public function update(Request $request, $id)
    {
        $compra = OrdenCompra::findOrFail($id);

        $data = $request->validate([
            'id_proveedor' => ['required', 'integer', 'exists:proveedor,id_proveedor'],
            'fecha'        => ['required', 'date'],
            'estado'       => ['required', 'in:pendiente,recibida,cancelada'],
            'total'        => ['nullable', 'numeric'],
        ]);

        $compra->update($data);

        return redirect()->route('compras.index')->with('ok', 'Compra actualizada.');
    }

    public function destroy($id)
    {
        // Si quieres borrar también los detalles:
        DB::table('detalle_orden_compra')->where('id_orden_compra', $id)->delete();

        OrdenCompra::findOrFail($id)->delete();

        return redirect()->route('compras.index')->with('ok', 'Compra eliminada.');
    }
}

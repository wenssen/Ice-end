<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{
    public function index()
    {
        // Lista productos + resumen de insumos de la receta
        $recetas = DB::table('producto_terminado as p')
            ->leftJoin('receta as r', 'r.id_producto', '=', 'p.id_producto')
            ->leftJoin('materia_prima as mp', 'mp.id_materia_prima', '=', 'r.id_materia_prima')
            ->select(
                'p.id_producto',
                'p.nombre',
                DB::raw("GROUP_CONCAT(mp.nombre ORDER BY mp.nombre SEPARATOR ', ') as insumos")
            )
            ->groupBy('p.id_producto', 'p.nombre')
            ->orderBy('p.nombre')
            ->get();

        return view('recetas.index', compact('recetas'));
    }

    public function create()
    {
        $productos = DB::table('producto_terminado')
            ->orderBy('nombre')
            ->get();

        $materias = DB::table('materia_prima')
            ->orderBy('nombre')
            ->get();

        return view('recetas.create', compact('productos', 'materias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_producto' => ['required', 'integer', 'exists:producto_terminado,id_producto'],

            'insumos' => ['required', 'array', 'min:1'],
            'insumos.*.id_materia_prima' => ['required', 'integer', 'exists:materia_prima,id_materia_prima'],
            'insumos.*.cantidad_requerida' => ['required', 'numeric', 'min:0.01'],
        ]);

        DB::transaction(function () use ($data) {

            // Reemplazar receta completa del producto (simple y seguro)
            DB::table('receta')->where('id_producto', $data['id_producto'])->delete();

            foreach ($data['insumos'] as $i) {
                DB::table('receta')->insert([
                    'id_producto' => $data['id_producto'],
                    'id_materia_prima' => $i['id_materia_prima'],
                    'cantidad_requerida' => $i['cantidad_requerida'],
                ]);
            }
        });

        return redirect()->route('recetas.index')->with('ok', 'Receta creada.');
    }

    public function show($idProducto)
    {
        $producto = DB::table('producto_terminado')->where('id_producto', $idProducto)->first();

        abort_if(!$producto, 404);

        $items = DB::table('receta as r')
            ->join('materia_prima as mp', 'mp.id_materia_prima', '=', 'r.id_materia_prima')
            ->where('r.id_producto', $idProducto)
            ->select('mp.nombre', 'mp.unidad_medida', 'r.cantidad_requerida', 'r.id_materia_prima')
            ->orderBy('mp.nombre')
            ->get();

        return view('recetas.show', compact('producto', 'items'));
    }

    public function edit($idProducto)
    {
        $producto = DB::table('producto_terminado')->where('id_producto', $idProducto)->first();
        abort_if(!$producto, 404);

        $materias = DB::table('materia_prima')->orderBy('nombre')->get();

        $items = DB::table('receta')
            ->where('id_producto', $idProducto)
            ->orderBy('id_materia_prima')
            ->get();

        return view('recetas.edit', compact('producto', 'materias', 'items'));
    }

    public function update(Request $request, $idProducto)
    {
        $data = $request->validate([
            'insumos' => ['required', 'array', 'min:1'],
            'insumos.*.id_materia_prima' => ['required', 'integer', 'exists:materia_prima,id_materia_prima'],
            'insumos.*.cantidad_requerida' => ['required', 'numeric', 'min:0.01'],
        ]);

        DB::transaction(function () use ($data, $idProducto) {
            DB::table('receta')->where('id_producto', $idProducto)->delete();

            foreach ($data['insumos'] as $i) {
                DB::table('receta')->insert([
                    'id_producto' => $idProducto,
                    'id_materia_prima' => $i['id_materia_prima'],
                    'cantidad_requerida' => $i['cantidad_requerida'],
                ]);
            }
        });

        return redirect()->route('recetas.show', $idProducto)->with('ok', 'Receta actualizada.');
    }
}

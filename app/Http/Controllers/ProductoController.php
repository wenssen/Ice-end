<?php

namespace App\Http\Controllers;

use App\Models\ProductoTerminado;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $productos = ProductoTerminado::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nombre', 'like', "%{$q}%")
                      ->orWhere('descripcion', 'like', "%{$q}%");
            })
            ->orderBy('id_producto', 'desc')
            ->get();

        return view('productos.index', compact('productos', 'q'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'             => ['required', 'string', 'max:100'],
            'descripcion'        => ['nullable', 'string'],
            'precio_venta'       => ['required', 'numeric', 'min:0'],
            'tiempo_preparacion' => ['nullable', 'integer', 'min:0'],
            'stock_actual'       => ['required', 'integer', 'min:0'],
            'stock_minimo'       => ['required', 'integer', 'min:0'],
        ]);

        ProductoTerminado::create($data);

        return redirect()->route('productos.index')
            ->with('ok', 'Producto creado.');
    }

    public function edit($id)
    {
        $producto = ProductoTerminado::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = ProductoTerminado::findOrFail($id);

        $data = $request->validate([
            'nombre'             => ['required', 'string', 'max:100'],
            'descripcion'        => ['nullable', 'string'],
            'precio_venta'       => ['required', 'numeric', 'min:0'],
            'tiempo_preparacion' => ['nullable', 'integer', 'min:0'],
            'stock_actual'       => ['required', 'integer', 'min:0'],
            'stock_minimo'       => ['required', 'integer', 'min:0'],
        ]);

        $producto->update($data);

        return redirect()->route('productos.index')
            ->with('ok', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        ProductoTerminado::findOrFail($id)->delete();

        return redirect()->route('productos.index')
            ->with('ok', 'Producto eliminado.');
    }
}

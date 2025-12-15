<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;
use App\Models\MateriaPrima;
use App\Models\ProductoTerminado;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        Proveedor::create([
            'nombre' => 'Proveedor Demo',
            'rut' => '11.111.111-1',
            'telefono' => '99999999',
            'email' => 'proveedor@demo.cl',
            'direccion' => 'Dirección demo',
            'estado' => 'activo',
        ]);

        MateriaPrima::create([
            'nombre' => 'Harina',
            'unidad_medida' => 'kg',
            'stock_actual' => 10,
            'stock_minimo' => 3,
            'costo_unitario' => 1200,
        ]);

        ProductoTerminado::create([
            'nombre' => 'Empanada',
            'descripcion' => 'Empanada de pino',
            'precio_venta' => 2500,
            'stock_actual' => 5,
            'stock_minimo' => 2,
            'tiempo_preparacion' => 30,
        ]);
    }
}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Proveedor: {{ $proveedor->nombre }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Datos del proveedor --}}
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold">Detalle</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}" class="btn btn-edit">
                            Editar
                        </a>
                        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                            Volver
                        </a>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><span class="font-semibold">RUT:</span> {{ $proveedor->rut ?? '—' }}</div>
                    <div><span class="font-semibold">Estado:</span> {{ $proveedor->estado ?? '—' }}</div>
                    <div><span class="font-semibold">Teléfono:</span> {{ $proveedor->telefono ?? '—' }}</div>
                    <div><span class="font-semibold">Email:</span> {{ $proveedor->email ?? '—' }}</div>
                </div>
            </div>

            {{-- Insumos comprados a este proveedor --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-4">Insumos comprados a este proveedor</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-2 text-left">Insumo</th>
                                <th class="p-2 text-left">Unidad</th>
                                <th class="p-2 text-right">Cantidad total</th>
                                <th class="p-2 text-right">Gasto total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($insumos as $i)
                                <tr class="border-b">
                                    <td class="p-2">{{ $i->nombre }}</td>
                                    <td class="p-2">{{ $i->unidad_medida ?? '—' }}</td>
                                    <td class="p-2 text-right">{{ number_format((float)$i->cantidad_total, 2, ',', '.') }}</td>
                                    <td class="p-2 text-right">{{ number_format((float)$i->gasto_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500">
                                        No hay insumos asociados a compras de este proveedor.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Historial de compras --}}
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Historial de compras</h3>

                    <a href="{{ route('compras.create') }}" class="btn btn-primary">
                        Registrar compra
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-2 text-left">ID</th>
                                <th class="p-2 text-left">Fecha</th>
                                <th class="p-2 text-left">Estado</th>
                                <th class="p-2 text-right">Total</th>
                                <th class="p-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($compras as $c)
                                <tr class="border-b">
                                    <td class="p-2">{{ $c->id_orden_compra }}</td>
                                    <td class="p-2">{{ $c->fecha ?? '—' }}</td>
                                    <td class="p-2">{{ $c->estado ?? '—' }}</td>
                                    <td class="p-2 text-right">{{ number_format((float)$c->total, 0, ',', '.') }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('compras.edit', $c->id_orden_compra) }}" class="btn btn-edit">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">
                                        No hay compras registradas para este proveedor.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Receta: {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Detalle</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('recetas.edit', $producto->id_producto) }}" class="btn btn-edit">Editar</a>
                        <a href="{{ route('recetas.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-2 text-left">Insumo</th>
                            <th class="p-2 text-left">Unidad</th>
                            <th class="p-2 text-right">Cantidad requerida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $it)
                            <tr class="border-b">
                                <td class="p-2">{{ $it->nombre }}</td>
                                <td class="p-2">{{ $it->unidad_medida ?? '—' }}</td>
                                <td class="p-2 text-right">{{ number_format((float)$it->cantidad_requerida, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-4 text-center text-gray-500">No hay insumos</td></tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

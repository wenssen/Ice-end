<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Alertas de Stock
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <p class="mb-4">
                    Insumos críticos: <b>{{ $criticos->count() }}</b>
                </p>

                <table class="w-full border">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2 text-left">Nombre</th>
                            <th class="p-2 text-left">Unidad</th>
                            <th class="p-2 text-left">Stock</th>
                            <th class="p-2 text-left">Mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($criticos as $m)
                        <tr class="border-b bg-red-100">
                            <td class="p-2">{{ $m->nombre }}</td>
                            <td class="p-2">{{ $m->unidad_medida }}</td>
                            <td class="p-2">{{ $m->stock_actual }}</td>
                            <td class="p-2">{{ $m->stock_minimo }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-2" colspan="4">No hay insumos en stock crítico.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

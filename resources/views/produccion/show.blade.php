<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Plan #{{ $plan->id_plan_produccion }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow space-y-4">

                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div><span class="font-semibold">Fecha plan:</span> {{ $plan->fecha_plan }}</div>
                    <div><span class="font-semibold">Fecha ejecución:</span> {{ $plan->fecha_ejecucion ?? '-' }}</div>
                    <div><span class="font-semibold">Estado:</span> {{ $plan->estado }}</div>
                </div>

                <div>
                    <h3 class="font-bold mb-2">Productos</h3>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2">Producto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plan->detalles as $d)
                                <tr class="border-b">
                                    <td class="py-2">{{ $d->producto?->nombre ?? 'Producto eliminado' }}</td>
                                    <td>{{ $d->cantidad_a_producir }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-2">
                    <a class="px-4 py-2 rounded bg-gray-100" href="{{ route('produccion.index') }}">Volver</a>

                    <form method="POST" action="{{ route('produccion.estado', $plan) }}" class="flex gap-2 items-center">
                        @csrf @method('PATCH')
                        <select name="estado" class="border rounded p-2 text-sm">
                            <option value="pendiente" @selected($plan->estado==='pendiente')>pendiente</option>
                            <option value="en_proceso" @selected($plan->estado==='en_proceso')>en_proceso</option>
                            <option value="finalizado" @selected($plan->estado==='finalizado')>finalizado</option>
                        </select>
                        <button class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Actualizar estado</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

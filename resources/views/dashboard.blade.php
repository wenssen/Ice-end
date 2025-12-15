<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            IceEnd Market — Menú Principal
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bienvenida --}}
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <div class="text-lg font-bold text-center">
                    Bienvenido, {{ auth()->user()->name }} ({{ auth()->user()->role }})
                </div>
            </div>

            {{-- ADMIN --}}
            @if(auth()->user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Planes Anteriores --}}
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold mb-4">Planes Anteriores</h3>
                        <table class="w-full text-sm text-gray-500 border border-gray-200 rounded-lg">
                            <thead class="bg-indigo-600 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Fecha</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $plan->id_plan_produccion }}</td>
                                        <td class="px-4 py-2">{{ $plan->fecha_plan }}</td>
                                        <td class="px-4 py-2">{{ $plan->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Insumos en Stock Crítico --}}
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold mb-4">Insumos en Stock Crítico</h3>
                        <table class="w-full text-sm text-gray-500 border border-gray-200 rounded-lg">
                            <thead class="bg-red-600 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">Insumo</th>
                                    <th class="px-4 py-2 text-left">Stock Actual</th>
                                    <th class="px-4 py-2 text-left">Stock Mínimo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($criticalStock as $insumo)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $insumo->nombre }}</td>
                                        <td class="px-4 py-2">{{ $insumo->stock_actual }}</td>
                                        <td class="px-4 py-2">{{ $insumo->stock_minimo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

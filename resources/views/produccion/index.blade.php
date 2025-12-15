<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Producción</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                {{-- HEADER DEL MÓDULO --}}
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Planes</h3>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('produccion.create') }}"
                           class="btn btn-primary">
                            Nuevo plan
                        </a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="p-3 mb-4 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2 w-16">ID</th>
                                <th class="w-40">Fecha plan</th>
                                <th class="w-44">Fecha ejecución</th>
                                <th class="w-40">Estado</th>
                                <th class="text-right w-56">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($planes as $p)
                                <tr class="border-b">
                                    <td class="py-2">{{ $p->id_plan_produccion }}</td>
                                    <td>{{ $p->fecha_plan }}</td>
                                    <td>{{ $p->fecha_ejecucion ?? '-' }}</td>
                                    <td class="capitalize">{{ str_replace('_',' ', $p->estado) }}</td>

                                    <td class="text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('produccion.show', $p) }}"
                                               class="px-4 py-2 rounded bg-gray-100 text-gray-900 text-sm font-semibold border border-gray-200 hover:bg-gray-200 transition">
                                                Ver
                                            </a>

                                            @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('produccion.edit', $p) }}"
                                                   class="px-4 py-2 rounded bg-indigo-100 text-indigo-700 text-sm font-semibold hover:bg-indigo-200 transition">
                                                    Editar
                                                </a>

                                                <form method="POST" action="{{ route('produccion.destroy', $p) }}"
                                                      onsubmit="return confirm('¿Eliminar plan?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="px-4 py-2 rounded bg-red-100 text-red-700 text-sm font-semibold hover:bg-red-200 transition">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500">
                                        Sin planes aún.
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Materia Prima
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                {{-- CABECERA IGUAL QUE EN PROVEEDORES --}}
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Listado</h3>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('materias-primas.create') }}" class="btn btn-primary">
                            Nueva materia prima
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left p-3 border-b">ID</th>
                                <th class="text-left p-3 border-b">Nombre</th>
                                <th class="text-left p-3 border-b">Unidad</th>
                                <th class="text-left p-3 border-b">Stock</th>
                                <th class="text-left p-3 border-b">Stock mínimo</th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="text-left p-3 border-b">Acciones</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @foreach ($materias as $m)
                                <tr class="border-b {{ $m->stock_actual < $m->stock_minimo ? 'bg-red-100' : '' }}">
                                    <td class="p-3">{{ $m->id_materia_prima }}</td>
                                    <td class="p-3">{{ $m->nombre }}</td>
                                    <td class="p-3">{{ $m->unidad_medida }}</td>
                                    <td class="p-3">{{ $m->stock_actual }}</td>
                                    <td class="p-3">{{ $m->stock_minimo }}</td>

                                    @if(auth()->user()->role === 'admin')
                                        <td class="p-3">
                                            <div class="table-actions">
                                                <a href="{{ route('materias-primas.edit', $m->id_materia_prima) }}"
                                                   class="btn btn-edit">
                                                    Editar
                                                </a>

                                                <form action="{{ route('materias-primas.destroy', $m->id_materia_prima) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('¿Eliminar?')"
                                                            class="btn btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

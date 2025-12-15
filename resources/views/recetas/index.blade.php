<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Recetas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Recetas Registradas</h3>

                    @if(auth()->user()->role === 'admin')
                        <a class="btn btn-primary" href="{{ route('recetas.create') }}">Nueva receta</a>
                    @endif
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-2 text-left">ID</th>
                            <th class="p-2 text-left">Producto</th>
                            <th class="p-2 text-left">Insumos</th>
                            <th class="p-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recetas as $r)
                            <tr class="border-b">
                                <td class="p-2">{{ $r->id_producto }}</td>
                                <td class="p-2">{{ $r->nombre }}</td>
                                <td class="p-2">{{ $r->insumos ?? '—' }}</td>
                                <td class="p-2 flex gap-2">
                                    <a class="btn btn-secondary" href="{{ route('recetas.show', $r->id_producto) }}">Ver</a>
                                    <a class="btn btn-edit" href="{{ route('recetas.edit', $r->id_producto) }}">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4 text-center text-gray-500">No hay recetas</td></tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

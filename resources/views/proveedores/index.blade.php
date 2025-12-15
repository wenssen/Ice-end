<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Proveedores
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Listado</h3>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
                            Nuevo proveedor
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left p-3 border-b">ID</th>
                                <th class="text-left p-3 border-b">Nombre</th>
                                <th class="text-left p-3 border-b">RUT</th>
                                <th class="text-left p-3 border-b">Teléfono</th>
                                <th class="text-left p-3 border-b">Email</th>
                                <th class="text-left p-3 border-b">Estado</th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="text-left p-3 border-b">Acciones</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @foreach($proveedores as $pr)
                                <tr class="border-b">
                                    <td class="p-3">{{ $pr->id_proveedor }}</td>
                                    <td class="p-3">{{ $pr->nombre }}</td>
                                    <td class="p-3">{{ $pr->rut }}</td>
                                    <td class="p-3">{{ $pr->telefono }}</td>
                                    <td class="p-3">{{ $pr->email }}</td>
                                    <td class="p-3">{{ $pr->estado }}</td>

                                    @if(auth()->user()->role === 'admin')
                                        <td class="p-3">
                                            <div class="table-actions">
                                                <a href="{{ route('proveedores.show', $pr->id_proveedor) }}" class="btn btn-secondary">
                                                    Ver
                                                </a>

                                                <a href="{{ route('proveedores.edit', $pr->id_proveedor) }}" class="btn btn-edit">
                                                    Editar
                                                </a>

                                                <form method="POST" action="{{ route('proveedores.destroy', $pr->id_proveedor) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar?')">
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

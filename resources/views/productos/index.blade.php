<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Productos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Lista de Productos</h3>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('productos.create') }}" class="btn btn-primary">
                            Nuevo producto
                        </a>
                    @endif
                </div>

                <form method="GET" class="mb-4">
                    <input name="q" value="{{ $q ?? '' }}" class="w-full rounded border-gray-300"
                           placeholder="Buscar producto...">
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-2 text-left">ID</th>
                                <th class="p-2 text-left">Nombre</th>
                                <th class="p-2 text-left">Tipo</th>
                                <th class="p-2 text-right">Stock</th>
                                <th class="p-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productos as $p)
                                <tr class="border-b">
                                    <td class="p-2">{{ $p->id_producto }}</td>
                                    <td class="p-2">{{ $p->nombre }}</td>
                                    {{-- En tu BD no existe "tipo", usamos descripcion como aproximación --}}
                                    <td class="p-2">{{ $p->descripcion ? \Illuminate\Support\Str::limit($p->descripcion, 25) : '—' }}</td>
                                    <td class="p-2 text-right">{{ $p->stock_actual }}</td>
                                    <td class="p-2 flex gap-2">
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('productos.edit', $p->id_producto) }}" class="btn btn-edit">
                                                Editar
                                            </a>
                                        @endif

                                        {{-- Receta: la tabla receta existe y cuelga del producto --}}
                                        {{-- Luego lo conectamos a tus rutas reales de recetas --}}
                                        <a href="{{ route('recetas.index') }}" class="btn btn-secondary">
                                            Receta
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">
                                        No hay productos registrados
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Compras
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Historial</h3>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('compras.create') }}" class="btn btn-primary">
                            Registrar compra
                        </a>
                    @endif
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2 text-left">ID</th>
                            <th class="p-2 text-left">Proveedor</th>
                            <th class="p-2 text-left">Fecha</th>
                            <th class="p-2 text-left">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($compras ?? [] as $c)
                            <tr class="border-b">
                                <td class="p-2">{{ $c->id_orden_compra }}</td>
                                <td class="p-2">{{ $c->proveedor?->nombre ?? '—' }}</td>
                                <td class="p-2">{{ $c->fecha ?? '—' }}</td>
                                <td class="p-2">
                                    <a href="{{ route('compras.edit', $c->id_orden_compra) }}"
                                       class="btn btn-edit">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">
                                    No hay compras registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios y Roles</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Usuarios del Sistema</h3>

                    <a href="{{ route('usuarios.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                        Nuevo usuario
                    </a>
                </div>

                @if(session('success'))
                    <div class="p-3 mb-4 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2 w-16">ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th class="w-40">Rol</th>
                                <th class="w-32">Estado</th>
                                <th class="text-right w-[28rem]">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $u)
                                <tr class="border-b">
                                    <td class="py-2">{{ $u->id }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->phone ?: '—' }}</td>
                                    <td class="capitalize">{{ str_replace('_',' ', $u->role ?? '-') }}</td>

                                    <td>
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $u->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $u->is_active ? 'activo' : 'inactivo' }}
                                        </span>
                                    </td>

                                    <td class="text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('usuarios.edit', $u) }}"
                                               class="px-4 py-2 rounded bg-indigo-100 text-indigo-700 text-sm font-semibold hover:bg-indigo-200 transition">
                                                Editar
                                            </a>

                                            {{-- Activar / Desactivar (no permitir auto-toggle) --}}
                                            @if(auth()->id() !== $u->id)
                                                <form method="POST" action="{{ route('usuarios.toggle', $u) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-4 py-2 rounded bg-gray-100 text-gray-900 text-sm font-semibold border border-gray-200 hover:bg-gray-200 transition">
                                                        {{ $u->is_active ? 'Desactivar' : 'Activar' }}
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Eliminar (evitar que el admin se borre a sí mismo) --}}
                                            @if(auth()->id() !== $u->id)
                                                <form method="POST" action="{{ route('usuarios.destroy', $u) }}"
                                                      onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
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
                                    <td colspan="7" class="py-6 text-center text-gray-500">Sin usuarios.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

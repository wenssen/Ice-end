<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar usuario #{{ $user->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                @if ($errors->any())
                    <div class="p-3 mb-4 rounded bg-red-100 text-red-800">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('usuarios.update', $user) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold mb-1">Nombre completo</label>
                        <input type="text" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Rol</label>
                        <select name="role"
                                class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($roles as $role)
                                <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>
                                    {{ ucfirst(str_replace('_',' ', $role)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Teléfono</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $user->phone ?? '') }}"
                               class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input id="is_active" type="checkbox" name="is_active" value="1"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                               {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                        <label for="is_active" class="text-sm font-semibold">Usuario activo</label>

                        @if(auth()->id() === $user->id)
                            <span class="text-xs text-gray-500">(no puedes desactivarte)</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                            Guardar cambios
                        </button>

                        <a href="{{ route('usuarios.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-200 rounded-md font-semibold text-sm text-gray-900 hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

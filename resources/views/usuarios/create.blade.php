<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo Usuario</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                @if ($errors->any())
                    <div class="p-3 rounded bg-red-100 text-red-800 mb-4">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('usuarios.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Nombre completo</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Rol</label>
                        <select name="role" class="w-full border rounded p-2" required>
                            <option value="">-- seleccionar --</option>
                            @foreach($roles as $r)
                                <option value="{{ $r }}" @selected(old('role')===$r)>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full border rounded p-2">
                    </div>

                    <div class="mb-6 flex items-center gap-2">
                        <input id="is_active" type="checkbox" name="is_active" value="1"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                               {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-semibold">Usuario activo</label>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                            Guardar Usuario
                        </button>

                        <a href="{{ route('usuarios.index') }}"
                           class="px-4 py-2 rounded bg-gray-100 text-gray-900 text-sm font-semibold border border-gray-200 hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

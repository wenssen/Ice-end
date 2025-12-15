<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Editar Proveedor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

                <form method="POST" action="{{ route('proveedores.update', $proveedor->id_proveedor) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nombre</label>
                            <input name="nombre" type="text"
                                   value="{{ $proveedor->nombre }}"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">RUT</label>
                            <input name="rut" type="text"
                                   value="{{ $proveedor->rut }}"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Teléfono</label>
                            <input name="telefono" type="text"
                                   value="{{ $proveedor->telefono }}"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email</label>
                            <input name="email" type="email"
                                   value="{{ $proveedor->email }}"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Estado</label>
                            <select name="estado"
                                    class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="activo"   @selected($proveedor->estado === 'activo')>activo</option>
                                <option value="inactivo" @selected($proveedor->estado === 'inactivo')>inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Actualizar
                        </button>

                        <a href="{{ route('proveedores.index') }}" class="btn btn-edit">
                            Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

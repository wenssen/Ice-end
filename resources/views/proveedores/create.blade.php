<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Nuevo Proveedor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

                <form method="POST" action="{{ route('proveedores.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nombre</label>
                            <input name="nombre" type="text"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                   placeholder="Ej: Proveedor X">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">RUT</label>
                            <input name="rut" type="text"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                   placeholder="Ej: 12.345.678-9">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Teléfono</label>
                            <input name="telefono" type="text"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                   placeholder="+56 9 ....">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email</label>
                            <input name="email" type="email"
                                   class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                   placeholder="correo@proveedor.com">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Estado</label>
                            <select name="estado"
                                    class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="activo">activo</option>
                                <option value="inactivo">inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Guardar
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

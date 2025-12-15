<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Nuevo Producto
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                @if ($errors->any())
                    <div class="p-3 rounded bg-red-50 text-red-700 mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('productos.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Nombre</label>
                            <input name="nombre"
                                   class="w-full rounded border-gray-300"
                                   value="{{ old('nombre') }}"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Descripción / Tipo</label>
                            <textarea name="descripcion"
                                      class="w-full rounded border-gray-300"
                                      rows="3"
                                      placeholder="Ej: Pastelería / Helados / etc.">{{ old('descripcion') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Precio venta</label>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="precio_venta"
                                   class="w-full rounded border-gray-300"
                                   value="{{ old('precio_venta') }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Tiempo preparación (min)</label>
                            <input type="number"
                                   step="1"
                                   min="0"
                                   name="tiempo_preparacion"
                                   class="w-full rounded border-gray-300"
                                   value="{{ old('tiempo_preparacion') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Stock actual</label>
                            <input type="number"
                                name="stock_actual"
                                step="1"
                                min="0"
                                inputmode="numeric"
                                class="w-full rounded border-gray-300"
                                value="{{ (int) old('stock_actual', 0) }}"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Stock mínimo</label>
                            <input type="number"
                                name="stock_minimo"
                                step="1"
                                min="0"
                                inputmode="numeric"
                                class="w-full rounded border-gray-300"
                                value="{{ (int) old('stock_minimo', 0) }}"
                                required>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <a class="btn btn-secondary" href="{{ route('productos.index') }}">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Registrar Compra
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow space-y-6">

                {{-- Errores --}}
                @if ($errors->any())
                    <div class="p-3 rounded bg-red-50 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('compras.store') }}">
                    @csrf

                    {{-- Proveedor --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Proveedor</label>
                        <select name="id_proveedor" class="w-full rounded border-gray-300" required>
                            <option value="">Selecciona</option>
                            @foreach($proveedores as $p)
                                <option value="{{ $p->id_proveedor }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Fecha</label>
                        <input type="date"
                               name="fecha"
                               class="w-full rounded border-gray-300"
                               value="{{ now()->toDateString() }}"
                               required>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Estado</label>
                        <select name="estado" class="w-full rounded border-gray-300" required>
                            <option value="pendiente" selected>Pendiente</option>
                            <option value="recibida">Recibida</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>

                    {{-- Insumos --}}
                    <h3 class="font-semibold mb-2">Insumos Comprados</h3>

                    <div id="insumos-container">
                        {{-- Insumo 0 --}}
                        <div class="insumo-item border rounded p-4 mb-3">
                            <div class="grid grid-cols-4 gap-4 items-end">
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Insumo</label>
                                    <select name="insumos[0][id]" class="w-full rounded border-gray-300" required>
                                        <option value="">Selecciona</option>
                                        @foreach($materias as $m)
                                            <option value="{{ $m->id_materia_prima }}">{{ $m->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Cantidad</label>
                                    <input type="number"
                                           step="0.01"
                                           name="insumos[0][cantidad]"
                                           class="w-full rounded border-gray-300"
                                           placeholder="Ej: 10"
                                           required>
                                </div>

                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Precio unitario</label>
                                    <input type="number"
                                           step="0.01"
                                           name="insumos[0][precio_unitario]"
                                           class="w-full rounded border-gray-300"
                                           placeholder="Ej: 1200"
                                           required>
                                </div>

                                <div class="w-full">
                                    <button type="button" class="btn btn-secondary btn-remove">
                                        Quitar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-insumo" class="btn btn-primary mb-3">
                        Agregar insumo
                    </button>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary">
                            Guardar compra
                        </button>
                        <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        let insumoIndex = 1;

        const addInsumoButton = document.getElementById('add-insumo');
        const insumosContainer = document.getElementById('insumos-container');

        addInsumoButton.addEventListener('click', function () {
            const div = document.createElement('div');
            div.classList.add('insumo-item', 'border', 'rounded', 'p-4', 'mb-3');

            div.innerHTML = `
                <div class="grid grid-cols-4 gap-4 items-end">
                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1">Insumo</label>
                        <select name="insumos[${insumoIndex}][id]" class="w-full rounded border-gray-300" required>
                            <option value="">Selecciona</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id_materia_prima }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1">Cantidad</label>
                        <input type="number"
                               step="0.01"
                               name="insumos[${insumoIndex}][cantidad]"
                               class="w-full rounded border-gray-300"
                               placeholder="Ej: 10"
                               required>
                    </div>

                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1">Precio unitario</label>
                        <input type="number"
                               step="0.01"
                               name="insumos[${insumoIndex}][precio_unitario]"
                               class="w-full rounded border-gray-300"
                               placeholder="Ej: 1200"
                               required>
                    </div>

                    <div class="w-full">
                        <button type="button" class="btn btn-secondary btn-remove">
                            Quitar
                        </button>
                    </div>
                </div>
            `;

            insumosContainer.appendChild(div);
            insumoIndex++;
        });

        // Delegación para eliminar items
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-remove')) {
                const item = e.target.closest('.insumo-item');
                if (!item) return;

                // opcional: impedir eliminar si es el único
                if (document.querySelectorAll('.insumo-item').length === 1) return;

                item.remove();
            }
        });
    </script>
</x-app-layout>

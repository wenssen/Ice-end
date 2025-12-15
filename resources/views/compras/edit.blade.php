<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Editar Compra
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow space-y-6">
                <form method="POST" action="{{ route('compras.update', $compra->id_orden_compra) }}">
                    @csrf
                    @method('PUT')

                    {{-- Proveedor --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Proveedor</label>
                        <select name="id_proveedor" class="w-full rounded border-gray-300" required>
                            <option value="">-- Selecciona --</option>
                            @foreach($proveedores as $p)
                                <option value="{{ $p->id_proveedor }}" @selected($p->id_proveedor == $compra->id_proveedor)>{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Insumos --}}
                    <h3 class="font-semibold mb-2">Insumos Comprados</h3>
                    <div id="insumos-container">
                        @foreach($compra->detalles as $index => $detalle)
                            <div class="insumo-item">
                                <div class="flex gap-3 mb-4">
                                    <div class="w-full">
                                        <label class="block text-sm font-medium mb-1">Insumo</label>
                                        <select name="insumos[{{ $index }}][id]" class="w-full rounded border-gray-300" required>
                                            <option value="">-- Selecciona --</option>
                                            @foreach($materias as $m)
                                                <option value="{{ $m->id_materia_prima }}" @selected($m->id_materia_prima == $detalle->id_materia_prima)>{{ $m->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-medium mb-1">Cantidad</label>
                                        <input type="number" name="insumos[{{ $index }}][cantidad]" class="w-full rounded border-gray-300" value="{{ $detalle->cantidad }}" required>
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-medium mb-1">Precio unitario</label>
                                        <input type="number" step="0.01" name="insumos[{{ $index }}][precio_unitario]" class="w-full rounded border-gray-300" value="{{ $detalle->precio_unitario }}" required>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-insumo" class="btn btn-primary mb-3">Agregar insumo</button>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ route('compras.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let insumoCount = {{ count($compra->detalles) }};
        const addInsumoButton = document.getElementById('add-insumo');
        const insumosContainer = document.getElementById('insumos-container');

        addInsumoButton.addEventListener('click', function () {
            const newInsumo = document.createElement('div');
            newInsumo.classList.add('insumo-item');
            newInsumo.innerHTML = `
                <div class="flex gap-3 mb-4">
                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1">Insumo</label>
                        <select name="insumos[${insumoCount}][id]" class="w-full rounded border-gray-300" required>
                            <option value="">-- Selecciona --</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id_materia_prima }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1">Cantidad</label>
                        <input type="number" name="insumos[${insumoCount}][cantidad]" class="w-full rounded border-gray-300" placeholder="Ej: 10" required>
                    </div>
                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1">Precio unitario</label>
                        <input type="number" step="0.01" name="insumos[${insumoCount}][precio_unitario]" class="w-full rounded border-gray-300" placeholder="Ej: 1200" required>
                    </div>
                </div>
            `;
            insumosContainer.appendChild(newInsumo);
            insumoCount++;
        });
    </script>
</x-app-layout>

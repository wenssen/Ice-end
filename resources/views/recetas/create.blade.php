<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Nueva Receta
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow space-y-6">

                @if ($errors->any())
                    <div class="p-3 rounded bg-red-50 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('recetas.store') }}">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-1">Producto</label>
                        <select name="id_producto" class="w-full rounded border-gray-300" required>
                            <option value="">Selecciona</option>
                            @foreach($productos as $p)
                                <option value="{{ $p->id_producto }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h3 class="font-semibold">Insumos</h3>

                    <div id="insumos-container">
                        <div class="insumo-item border rounded p-4 mb-3">
                            <div class="grid grid-cols-3 gap-4 items-end">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Insumo</label>
                                    <select name="insumos[0][id_materia_prima]" class="w-full rounded border-gray-300" required>
                                        <option value="">Selecciona</option>
                                        @foreach($materias as $m)
                                            <option value="{{ $m->id_materia_prima }}">{{ $m->nombre }} ({{ $m->unidad_medida }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Cantidad requerida</label>
                                    <input type="number" step="0.01" name="insumos[0][cantidad_requerida]" class="w-full rounded border-gray-300" required>
                                </div>

                                <div>
                                    <button type="button" class="btn btn-secondary btn-remove">Quitar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-insumo" class="btn btn-primary">Agregar insumo</button>

                    <div class="flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('recetas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        let idx = 1;
        const addBtn = document.getElementById('add-insumo');
        const container = document.getElementById('insumos-container');

        addBtn.addEventListener('click', () => {
            const div = document.createElement('div');
            div.classList.add('insumo-item', 'border', 'rounded', 'p-4', 'mb-3');

            div.innerHTML = `
                <div class="grid grid-cols-3 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium mb-1">Insumo</label>
                        <select name="insumos[${idx}][id_materia_prima]" class="w-full rounded border-gray-300" required>
                            <option value="">Selecciona</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id_materia_prima }}">{{ $m->nombre }} ({{ $m->unidad_medida }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Cantidad requerida</label>
                        <input type="number" step="0.01" name="insumos[${idx}][cantidad_requerida]" class="w-full rounded border-gray-300" required>
                    </div>

                    <div>
                        <button type="button" class="btn btn-secondary btn-remove">Quitar</button>
                    </div>
                </div>
            `;
            container.appendChild(div);
            idx++;
        });

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.insumo-item')?.remove();
            }
        });
    </script>
</x-app-layout>

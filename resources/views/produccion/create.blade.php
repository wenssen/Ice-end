<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo plan</h2>
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

                <form method="POST" action="{{ route('produccion.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Fecha plan</label>
                        <input type="date" name="fecha_plan" value="{{ old('fecha_plan') }}"
                               class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-2 flex items-center justify-between">
                        <h3 class="font-bold">Productos</h3>
                        <button type="button" id="addRow" class="px-3 py-1 rounded bg-gray-100">
                            Agregar producto
                        </button>
                    </div>

                    <div id="rows" class="space-y-3">
                        {{-- primera fila --}}
                        <div class="grid grid-cols-12 gap-2 items-end row-item">
                            <div class="col-span-8">
                                <label class="block text-sm">Producto</label>
                                <select name="items[0][id_producto]" class="w-full border rounded p-2" required>
                                    <option value="">-- seleccionar --</option>
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->id_producto }}">{{ $prod->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label class="block text-sm">Cantidad</label>
                                <input type="number" min="1" name="items[0][cantidad]"
                                       class="w-full border rounded p-2" required>
                            </div>
                            <div class="col-span-1">
                                <button type="button" class="removeRow px-2 py-2 rounded bg-red-50 text-red-700 w-full">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <button class="px-4 py-2 rounded bg-blue-600 text-white">Guardar plan</button>
                        <a class="px-4 py-2 rounded bg-gray-100" href="{{ route('produccion.index') }}">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        let idx = 1;

        document.getElementById('addRow').addEventListener('click', () => {
            const rows = document.getElementById('rows');
            const div = document.createElement('div');
            div.className = 'grid grid-cols-12 gap-2 items-end row-item';
            div.innerHTML = `
                <div class="col-span-8">
                    <label class="block text-sm">Producto</label>
                    <select name="items[${idx}][id_producto]" class="w-full border rounded p-2" required>
                        <option value="">-- seleccionar --</option>
                        @foreach($productos as $prod)
                            <option value="{{ $prod->id_producto }}">{{ $prod->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-3">
                    <label class="block text-sm">Cantidad</label>
                    <input type="number" min="1" name="items[${idx}][cantidad]" class="w-full border rounded p-2" required>
                </div>
                <div class="col-span-1">
                    <button type="button" class="removeRow px-2 py-2 rounded bg-red-50 text-red-700 w-full">✕</button>
                </div>
            `;
            rows.appendChild(div);
            idx++;
        });

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('removeRow')) {
                const all = document.querySelectorAll('.row-item');
                if (all.length <= 1) return;
                e.target.closest('.row-item').remove();
            }
        });
    </script>
</x-app-layout>

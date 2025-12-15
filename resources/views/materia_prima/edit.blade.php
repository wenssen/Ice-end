<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Editar Información
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form class="form" method="POST" action="{{ route('materias-primas.update', $materia->id_materia_prima) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div>
                            <label class="label">Nombre</label>
                            <input class="input" name="nombre" value="{{ old('nombre', $materia->nombre) }}" required>
                            @error('nombre') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="label">Unidad</label>
                            <input class="input" name="unidad_medida" value="{{ old('unidad_medida', $materia->unidad_medida) }}" required>
                            @error('unidad_medida') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="label">Stock actual</label>
                            <input class="input" type="number" step="0.01" name="stock_actual" value="{{ old('stock_actual', $materia->stock_actual) }}" required>
                            @error('stock_actual') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="label">Stock mínimo</label>
                            <input class="input" type="number" step="0.01" name="stock_minimo" value="{{ old('stock_minimo', $materia->stock_minimo) }}" required>
                            @error('stock_minimo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="label">Costo unitario</label>
                            <input class="input" type="number" step="0.01" name="costo_unitario" value="{{ old('costo_unitario', $materia->costo_unitario) }}">
                            @error('costo_unitario') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="actions-row pt-2">
                        <button class="btn btn-primary" type="submit">Actualizar</button>
                        <a class="btn btn-secondary" href="{{ route('materias-primas.index') }}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

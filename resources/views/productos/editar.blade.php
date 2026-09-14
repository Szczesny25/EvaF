@extends('layouts.app')

@section('titulo', 'Editar producto')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Editar producto</h1>

<div class="bg-white rounded shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('productos.actualizar', $producto) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-molecules.campo-formulario name="sku" label="SKU" :value="$producto->sku" />
        <x-molecules.campo-formulario name="nombre" label="Nombre" :value="$producto->nombre" />
        <x-molecules.campo-formulario name="descr_corta" label="Descripción corta" :value="$producto->descr_corta" />
        <x-molecules.campo-formulario name="descr_larga" label="Descripción larga" :value="$producto->descr_larga" />

        <div class="mb-4">
            <x-atoms.label for="imagen">Imagen actual</x-atoms.label>
            <img src="{{ Storage::url($producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-16 h-16 object-cover rounded mb-2">
            <input type="file" name="imagen" id="imagen" class="w-full text-sm">
            <p class="text-xs text-gray-400 mt-1">Deja este campo vacío si no quieres cambiar la imagen.</p>
            @error('imagen')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <x-molecules.campo-formulario name="precio_neto" label="Precio neto" type="number" :value="$producto->precio_neto" />

        <p class="text-xs text-gray-400 -mt-3 mb-4">
            El precio con IVA (19%) se recalcula automáticamente al guardar.
        </p>

        <x-molecules.campo-formulario name="stock_actual" label="Stock actual" type="number" :value="$producto->stock_actual" />
        <x-molecules.campo-formulario name="stock_minimo" label="Stock mínimo" type="number" :value="$producto->stock_minimo" />
        <x-molecules.campo-formulario name="stock_bajo" label="Umbral de stock bajo" type="number" :value="$producto->stock_bajo" />
        <x-molecules.campo-formulario name="stock_alto" label="Umbral de stock alto" type="number" :value="$producto->stock_alto" />

        <div class="flex gap-2 mt-4">
            <x-atoms.boton tipo="submit">Actualizar</x-atoms.boton>
            <a href="{{ route('productos.index') }}">
                <x-atoms.boton tipo="button" variante="secundario">Cancelar</x-atoms.boton>
            </a>
        </div>
    </form>
</div>
@endsection
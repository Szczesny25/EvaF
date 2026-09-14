@extends('layouts.app')

@section('titulo', 'Nuevo producto')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Nuevo producto</h1>

<div class="bg-white rounded shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('productos.guardar') }}" enctype="multipart/form-data">
        @csrf

        <x-molecules.campo-formulario name="sku" label="SKU" />
        <x-molecules.campo-formulario name="nombre" label="Nombre" />
        <x-molecules.campo-formulario name="descr_corta" label="Descripción corta" />
        <x-molecules.campo-formulario name="descr_larga" label="Descripción larga" />

        <div class="mb-4">
            <x-atoms.label for="imagen">Imagen</x-atoms.label>
            <input type="file" name="imagen" id="imagen" class="w-full text-sm">
            @error('imagen')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <x-molecules.campo-formulario name="precio_neto" label="Precio neto" type="number" />

        <p class="text-xs text-gray-400 -mt-3 mb-4">
            El precio con IVA (19%) se calcula automáticamente al guardar.
        </p>

        <x-molecules.campo-formulario name="stock_actual" label="Stock actual" type="number" />
        <x-molecules.campo-formulario name="stock_minimo" label="Stock mínimo" type="number" />
        <x-molecules.campo-formulario name="stock_bajo" label="Umbral de stock bajo" type="number" />
        <x-molecules.campo-formulario name="stock_alto" label="Umbral de stock alto" type="number" />

        <div class="flex gap-2 mt-4">
            <x-atoms.boton tipo="submit">Guardar</x-atoms.boton>
            <a href="{{ route('productos.index') }}">
                <x-atoms.boton tipo="button" variante="secundario">Cancelar</x-atoms.boton>
            </a>
        </div>
    </form>
</div>
@endsection
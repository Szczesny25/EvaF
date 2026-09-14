@extends('layouts.app')

@section('titulo', 'Nuevo cliente')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Nuevo cliente</h1>

<div class="bg-white rounded shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('clientes.guardar') }}">
        @csrf

        <x-molecules.campo-formulario name="rut_empresa" label="Rut empresa" />

        <x-molecules.campo-select name="rubro" label="Rubro">
            <option value="">Selecciona un rubro</option>
            @foreach (\App\Models\Cliente::RUBROS as $rubro)
                <option value="{{ $rubro }}" @selected(old('rubro') == $rubro)>{{ ucfirst($rubro) }}</option>
            @endforeach
        </x-molecules.campo-select>

        <x-molecules.campo-formulario name="razon_social" label="Razón social" />
        <x-molecules.campo-formulario name="telefono" label="Teléfono" />
        <x-molecules.campo-formulario name="direccion" label="Dirección" />
        <x-molecules.campo-formulario name="nombre_contacto" label="Nombre de contacto" />
        <x-molecules.campo-formulario name="email_contacto" label="Correo de contacto" type="email" />

        <div class="flex gap-2 mt-4">
            <x-atoms.boton tipo="submit">Guardar</x-atoms.boton>
            <a href="{{ route('clientes.index') }}">
                <x-atoms.boton tipo="button" variante="secundario">Cancelar</x-atoms.boton>
            </a>
        </div>
    </form>
</div>
@endsection
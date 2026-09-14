@extends('layouts.app')

@section('titulo', 'Editar cliente')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Editar cliente</h1>

<div class="bg-white rounded shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('clientes.actualizar', $cliente) }}">
        @csrf
        @method('PUT')

        <x-molecules.campo-formulario name="rut_empresa" label="Rut empresa" :value="$cliente->rut_empresa" />

        <x-molecules.campo-select name="rubro" label="Rubro">
            @foreach (\App\Models\Cliente::RUBROS as $rubro)
                <option value="{{ $rubro }}" @selected(old('rubro', $cliente->rubro) == $rubro)>{{ ucfirst($rubro) }}</option>
            @endforeach
        </x-molecules.campo-select>

        <x-molecules.campo-formulario name="razon_social" label="Razón social" :value="$cliente->razon_social" />
        <x-molecules.campo-formulario name="telefono" label="Teléfono" :value="$cliente->telefono" />
        <x-molecules.campo-formulario name="direccion" label="Dirección" :value="$cliente->direccion" />
        <x-molecules.campo-formulario name="nombre_contacto" label="Nombre de contacto" :value="$cliente->nombre_contacto" />
        <x-molecules.campo-formulario name="email_contacto" label="Correo de contacto" type="email" :value="$cliente->email_contacto" />

        <div class="flex gap-2 mt-4">
            <x-atoms.boton tipo="submit">Actualizar</x-atoms.boton>
            <a href="{{ route('clientes.index') }}">
                <x-atoms.boton tipo="button" variante="secundario">Cancelar</x-atoms.boton>
            </a>
        </div>
    </form>
</div>
@endsection
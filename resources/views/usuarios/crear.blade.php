@extends('layouts.app')

@section('titulo', 'Nuevo usuario')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Nuevo usuario</h1>

<div class="bg-white rounded shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('usuarios.guardar') }}">
        @csrf

        <x-molecules.campo-formulario name="rut" label="Rut" />
        <x-molecules.campo-formulario name="nombre" label="Nombre" />
        <x-molecules.campo-formulario name="apellido" label="Apellido" />
        <x-molecules.campo-formulario name="correo" label="Correo (@ventasfix.cl)" type="email" />
        <x-molecules.campo-formulario name="contraseña" label="Contraseña" type="password" />

        <div class="flex gap-2 mt-4">
            <x-atoms.boton tipo="submit">Guardar</x-atoms.boton>
            <a href="{{ route('usuarios.index') }}">
                <x-atoms.boton tipo="button" variante="secundario">Cancelar</x-atoms.boton>
            </a>
        </div>
    </form>
</div>
@endsection
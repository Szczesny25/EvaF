@extends('layouts.app')

@section('titulo', 'Editar usuario')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Editar usuario</h1>

<div class="bg-white rounded shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('usuarios.actualizar', $usuario) }}">
        @csrf
        @method('PUT')

        <x-molecules.campo-formulario name="rut" label="Rut" :value="$usuario->rut" />
        <x-molecules.campo-formulario name="nombre" label="Nombre" :value="$usuario->nombre" />
        <x-molecules.campo-formulario name="apellido" label="Apellido" :value="$usuario->apellido" />
        <x-molecules.campo-formulario name="correo" label="Correo (@ventasfix.cl)" type="email" :value="$usuario->correo" />
        <x-molecules.campo-formulario name="contraseña" label="Nueva contraseña (opcional)" type="password" />

        <div class="flex gap-2 mt-4">
            <x-atoms.boton tipo="submit">Actualizar</x-atoms.boton>
            <a href="{{ route('usuarios.index') }}">
                <x-atoms.boton tipo="button" variante="secundario">Cancelar</x-atoms.boton>
            </a>
        </div>
    </form>
</div>
@endsection
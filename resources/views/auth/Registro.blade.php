@extends('layouts.invitado')

@section('titulo', 'Crear cuenta')

@section('contenido')
<div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h1 class="text-xl font-bold mb-6 text-center">Crear cuenta</h1>

    <form method="POST" action="{{ route('registro') }}">
        @csrf

        <x-molecules.campo-formulario name="rut" label="Rut" />
        <x-molecules.campo-formulario name="nombre" label="Nombre" />
        <x-molecules.campo-formulario name="apellido" label="Apellido" />
        <x-molecules.campo-formulario name="correo" label="Correo (@ventasfix.cl)" type="email" />
        <x-molecules.campo-formulario name="contraseña" label="Contraseña" type="password" />

        <x-atoms.boton tipo="submit" class="w-full mt-2">
            Registrarme
        </x-atoms.boton>
    </form>

    <a href="{{ route('login') }}" class="block mt-4 text-center text-sm text-blue-600 hover:underline">
        tiene cuenta, entonce vente pa ca
    </a>
</div>
@endsection
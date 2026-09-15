@extends('layouts.invitado')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h1 class="text-xl font-bold mb-6 text-center">VentasFix - Backoffice</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-molecules.campo-formulario name="correo" label="Correo" type="email" />
        <x-molecules.campo-formulario name="contraseña" label="Contraseña" type="password" />

        <x-atoms.boton tipo="submit" class="w-full mt-2">
            Ingresar
        </x-atoms.boton>
    </form>

    <a href="{{ route('registro') }}" class="block mt-4 text-center text-sm text-blue-600 hover:underline">
        create una cuantita que e grati!!
    </a>
</div>
@endsection
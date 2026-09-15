@extends('layouts.app')

@section('titulo', 'Usuarios')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Usuarios</h1>
    <a href="{{ route('usuarios.crear') }}">
        <x-atoms.boton tipo="button">Nuevo usuario</x-atoms.boton>
    </a>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="px-4 py-2">Rut</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Apellido</th>
                <th class="px-4 py-2">Correo</th>
                <th class="px-4 py-2 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $usuario->rut }}</td>
                    <td class="px-4 py-2">{{ $usuario->nombre }}</td>
                    <td class="px-4 py-2">{{ $usuario->apellido }}</td>
                    <td class="px-4 py-2">{{ $usuario->correo }}</td>
                    <td class="px-4 py-2 text-right space-x-2">
                        <a href="{{ route('usuarios.editar', $usuario) }}" class="text-blue-600 hover:underline">Editar</a>

                        <form action="{{ route('usuarios.eliminar', $usuario) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $usuarios->links() }}
</div>
@endsection
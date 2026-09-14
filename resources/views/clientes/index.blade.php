@extends('layouts.app')

@section('titulo', 'Clientes')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Clientes</h1>
    <a href="{{ route('clientes.crear') }}">
        <x-atoms.boton tipo="button">Nuevo cliente</x-atoms.boton>
    </a>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="px-4 py-2">Rut empresa</th>
                <th class="px-4 py-2">Razón social</th>
                <th class="px-4 py-2">Rubro</th>
                <th class="px-4 py-2">Contacto</th>
                <th class="px-4 py-2 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $cliente)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $cliente->rut_empresa }}</td>
                    <td class="px-4 py-2">{{ $cliente->razon_social }}</td>
                    <td class="px-4 py-2">{{ ucfirst($cliente->rubro) }}</td>
                    <td class="px-4 py-2">{{ $cliente->nombre_contacto }} ({{ $cliente->email_contacto }})</td>
                    <td class="px-4 py-2 text-right space-x-2">
                        <a href="{{ route('clientes.editar', $cliente) }}" class="text-blue-600 hover:underline">Editar</a>

                        <form action="{{ route('clientes.eliminar', $cliente) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar este cliente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">No hay clientes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $clientes->links() }}
</div>
@endsection
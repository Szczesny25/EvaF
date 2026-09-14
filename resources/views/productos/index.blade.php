@extends('layouts.app')

@section('titulo', 'Productos')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Productos</h1>
    <a href="{{ route('productos.crear') }}">
        <x-atoms.boton tipo="button">Nuevo producto</x-atoms.boton>
    </a>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="px-4 py-2">Imagen</th>
                <th class="px-4 py-2">SKU</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Precio neto</th>
                <th class="px-4 py-2">Precio c/IVA</th>
                <th class="px-4 py-2">Stock</th>
                <th class="px-4 py-2 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        <img src="{{ Storage::url($producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-10 h-10 object-cover rounded">
                    </td>
                    <td class="px-4 py-2">{{ $producto->sku }}</td>
                    <td class="px-4 py-2">{{ $producto->nombre }}</td>
                    <td class="px-4 py-2">${{ number_format($producto->precio_neto, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">${{ number_format($producto->Precio_Cimpuesto, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        {{ $producto->stock_actual }}
                        @php $estado = $producto->estado_stock; @endphp
                        <span class="ml-1 px-2 py-0.5 rounded text-xs
                            {{ $estado === 'bajo' ? 'bg-red-100 text-red-700' : ($estado === 'alto' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ ucfirst($estado) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right space-x-2">
                        <a href="{{ route('productos.editar', $producto) }}" class="text-blue-600 hover:underline">Editar</a>

                        <form action="{{ route('productos.eliminar', $producto) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">No hay productos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $productos->links() }}
</div>
@endsection
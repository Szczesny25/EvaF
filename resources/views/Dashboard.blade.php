@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded shadow p-6">
        <p class="text-gray-500 text-sm">Usuarios</p>
        <p class="text-3xl font-bold">{{ $totalUsuarios }}</p>
    </div>

    <div class="bg-white rounded shadow p-6">
        <p class="text-gray-500 text-sm">Productos</p>
        <p class="text-3xl font-bold">{{ $totalProductos }}</p>
    </div>

    <div class="bg-white rounded shadow p-6">
        <p class="text-gray-500 text-sm">Clientes</p>
        <p class="text-3xl font-bold">{{ $totalClientes }}</p>
    </div>
</div>
@endsection
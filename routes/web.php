<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar']);

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('jwt.web')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UsuarioController::class, 'crear'])->name('usuarios.crear');
    Route::post('/usuarios', [UsuarioController::class, 'guardar'])->name('usuarios.guardar');
    Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'editar'])->name('usuarios.editar');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'actualizar'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'eliminar'])->name('usuarios.eliminar');

    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear', [ProductoController::class, 'crear'])->name('productos.crear');
    Route::post('/productos', [ProductoController::class, 'guardar'])->name('productos.guardar');
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'editar'])->name('productos.editar');
    Route::put('/productos/{producto}', [ProductoController::class, 'actualizar'])->name('productos.actualizar');
    Route::delete('/productos/{producto}', [ProductoController::class, 'eliminar'])->name('productos.eliminar');

    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear', [ClienteController::class, 'crear'])->name('clientes.crear');
    Route::post('/clientes', [ClienteController::class, 'guardar'])->name('clientes.guardar');
    Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'editar'])->name('clientes.editar');
    Route::put('/clientes/{cliente}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
    Route::delete('/clientes/{cliente}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');
});
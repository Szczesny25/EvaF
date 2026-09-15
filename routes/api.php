<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\UsuarioControllerSwagger;
use App\Http\Controllers\ProductoControllerSwagger;
use App\Http\Controllers\ClienteControllerSwagger;

// Login de la API: público, retorna el JWT que se debe usar en el resto de rutas.
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('jwt')->group(function () {

    // Usuarios
    Route::get('/usuarios', [UsuarioControllerSwagger::class, 'index']);
    Route::get('/usuarios/{usuario}', [UsuarioControllerSwagger::class, 'show']);
    Route::post('/usuarios', [UsuarioControllerSwagger::class, 'store']);
    Route::put('/usuarios/{usuario}', [UsuarioControllerSwagger::class, 'update']);
    Route::delete('/usuarios/{usuario}', [UsuarioControllerSwagger::class, 'destroy']);

    // Productos
    Route::get('/productos', [ProductoControllerSwagger::class, 'index']);
    Route::get('/productos/{producto}', [ProductoControllerSwagger::class, 'show']);
    Route::post('/productos', [ProductoControllerSwagger::class, 'store']);
    Route::put('/productos/{producto}', [ProductoControllerSwagger::class, 'update']);
    Route::delete('/productos/{producto}', [ProductoControllerSwagger::class, 'destroy']);

    // Clientes
    Route::get('/clientes', [ClienteControllerSwagger::class, 'index']);
    Route::get('/clientes/{cliente}', [ClienteControllerSwagger::class, 'show']);
    Route::post('/clientes', [ClienteControllerSwagger::class, 'store']);
    Route::put('/clientes/{cliente}', [ClienteControllerSwagger::class, 'update']);
    Route::delete('/clientes/{cliente}', [ClienteControllerSwagger::class, 'destroy']);
});
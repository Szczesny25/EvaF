<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Usuario;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = Usuario::count();
        $totalProductos = Producto::count();
        $totalClientes = Cliente::count();

        return view('dashboard', compact('totalUsuarios', 'totalProductos', 'totalClientes'));
    }
}
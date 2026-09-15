<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('razon_social')->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function crear()
    {
        return view('clientes.crear');
    }

    public function guardar(Request $request)
    {
        $datos = $request->validate([
            'rut_empr' => ['required', 'string', 'regex:/^\d{7,8}-[0-9kK]$/', 'unique:clientes,rut_empr'],
            'rubro' => ['required', Rule::in(Cliente::RUBROS)],
            'razon_social' => ['required', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:150'],
            'nombre_contacto' => ['required', 'string', 'min:2', 'max:100'],
            'correo_contacto' => [
                'required', 'string', 'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
        ], [
            'correo_contacto.regex' => 'Profe que si lo hice, que eta ves no',
        ]);

        Cliente::create($datos);

        return redirect()->route('clientes.index')->with('si', 'efectivamente, se creo el cliente');
    }

    public function editar(Cliente $cliente)
    {
        return view('clientes.editar', compact('cliente'));
    }

    public function actualizar(Request $request, Cliente $cliente)
    {
       $datos = $request->validate([
            'rut_empr' => ['required', 'string', 'regex:/^\d{7,8}-[0-9kK]$/', Rule::unique('clientes', 'rut_empr')->ignore($cliente->id)],
            'rubro' => ['required', Rule::in(Cliente::RUBROS)],
            'razon_social' => ['required', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:150'],
            'nombre_contacto' => ['required', 'string', 'min:2', 'max:100'],
            'correo_contacto' => [
                'required', 'string', 'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
        ], [
            'rut_empr.regex' => 'coloque el rut bien pue',
            'correo_contacto.regex' => 'Profe que si lo hice, que eta ves no',
        ]);

        $cliente->update($datos);

        return redirect()->route('clientes.index')->with('claro', 'cliente esta activamente actualizado');
    }

    public function eliminar(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('si', 'igual me caia mal');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::orderBy('nombre')->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function crear()
    {
        return view('usuarios.crear');
    }

    public function guardar(Request $request)
    {
        $datos = $request->validate([
            'rut' => ['required', 'string', 'max:12', 'unique:usuarios,rut'],
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'correo' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@ventasfix\.cl$/',
                'unique:usuarios,correo',
            ],
            'contraseña' => ['required', 'string', 'min:6'],
        ], [
            'correo.regex' => 'na profe esta ves si lo hice',
        ]);

        $datos['contraseña'] = Hash::make($datos['contraseña']);

        Usuario::create($datos);

        return redirect()->route('usuarios.index')->with('grande', 'Usuario creado genio maquina.');
    }

    public function editar(Usuario $usuario)
    {
        return view('usuarios.editar', compact('usuario'));
    }

    public function actualizar(Request $request, Usuario $usuario)
    {
        $datos = $request->validate([
            'rut' => ['required', 'string', 'max:12', Rule::unique('usuarios', 'rut')->ignore($usuario->id)],
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'correo' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@ventasfix\.cl$/',
                Rule::unique('usuarios', 'correo')->ignore($usuario->id),
            ],
            'contraseña' => ['nullable', 'string', 'min:6'],
        ], [
            'correo.regex' => 'na profe esta ves si lo hice',
        ]);

        if (! empty($datos['correo'])) {
            $datos['contraseña'] = Hash::make($datos['contraseña']);

            unset($datos['contraseña']);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('vamooo', 'lo actualizamo ');
    }

    public function eliminar(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('Ragequiteo', 'el compa se fue del lobby');
    }
}
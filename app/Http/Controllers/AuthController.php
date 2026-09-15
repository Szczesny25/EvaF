<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\JwtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $datos = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        $usuario = Usuario::where('correo', $datos['correo'])->first();

        if (! $usuario || ! Hash::check($datos['contraseña'], $usuario->contraseña)) {
            return back()->withErrors([
                'correo' => 'Correo no eta D:.',
            ])->onlyInput('correo');
        }

        $token = JwtService::generar([
            'id' => $usuario->id,
            'correo' => $usuario->correo,
            'nombre' => $usuario->nombre,
        ]);

        $request->session()->put('jwt', $token);

        return redirect()->route('dashboard');
    }

    /**
     * Cierra la sesión eliminando el JWT guardado.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('jwt');

        return redirect()->route('login');
    }

    public function mostrarRegistro()
    {
        return view('auth.registro');
    }
 
    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'rut' => ['required', 'string', 'regex:/^\d{7,8}-[0-9kK]$/', 'unique:usuarios,rut'],
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellido' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@ventasfix\.cl$/',
                'unique:usuarios,correo',
            ],
            'contraseña' => ['required', 'string', 'min:6'],
        ], [
            'correo.regex' => 'esta mal pusido el correo',
            'rut.regex' => 'El rut debe tener el formato 12345678-9 (sin puntos).',
        ]);
 
        $datos['contraseña'] = Hash::make($datos['contraseña']);
 
        Usuario::create($datos);
 
        return redirect()->route('login')->with('ea', 'tamo redi pai');
    }
}
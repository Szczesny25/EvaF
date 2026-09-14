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
            'correo' => 'required|correo',
            'contraseña' => 'required|string',
        ]);

        $usuario = Usuario::where('correo', $datos['correo'])->first();

        if (! $usuario || ! Hash::check($datos['contraseña'], $usuario->password)) {
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
}
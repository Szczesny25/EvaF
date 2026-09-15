<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\JwtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthApiController extends Controller
{
    #[OA\Post(
        path: '/login',
        summary: 'ta weno el usuario',
        tags: ['Autenticación'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['correo', 'contraseña'],
                properties: [
                    new OA\Property(property: 'correo', type: 'string', example: 'admin@ventasfix.cl'),
                    new OA\Property(property: 'contraseña', type: 'string', example: 'Admin123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'toi dentro'),
            new OA\Response(response: 401, description: 'no, no ere ese'),
        ]
    )]
    public function login(Request $request)
    {
        $datos = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        $usuario = Usuario::where('correo', $datos['correo'])->first();

        if (! $usuario || ! Hash::check($datos['contraseña'], $usuario->contraseña)) {
            return response()->json([
                'mensaje' => 'que tu no ere ese',
            ], 401);
        }

        $token = JwtService::generar([
            'id' => $usuario->id,
            'correo' => $usuario->correo,
            'nombre' => $usuario->nombre,
        ]);

        return response()->json([
            'token' => $token,
            'usuario' => $usuario,
        ]);
    }
}
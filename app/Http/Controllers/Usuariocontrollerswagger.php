<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class UsuarioControllerSwagger extends Controller
{
    #[OA\Get(
        path: '/usuarios',
        summary: 'todo lo pokemone',
        tags: ['Usuarios'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'aqui etan'),
            new OA\Response(response: 401, description: 'no eta'),
        ]
    )]
    public function index()
    {
        return response()->json(Usuario::all());
    }

    #[OA\Get(
        path: '/usuarios/{usuario}',
        summary: 'dime tu edad y sabre que edad tienes',
        tags: ['Usuarios'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'usuario', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'aqui eta el chavo'),
            new OA\Response(response: 404, description: 'se perdio'),
        ]
    )]
    public function show(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    #[OA\Post(
        path: '/usuarios',
        summary: 'uno mas',
        tags: ['Usuarios'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['rut', 'nombre', 'apellido', 'correo', 'contraseña'],
                properties: [
                    new OA\Property(property: 'rut', type: 'string', example: '12345678-9'),
                    new OA\Property(property: 'nombre', type: 'string', example: 'Juan'),
                    new OA\Property(property: 'apellido', type: 'string', example: 'Pérez'),
                    new OA\Property(property: 'correo', type: 'string', example: 'juan.perez@ventasfix.cl'),
                    new OA\Property(property: 'contraseña', type: 'string', example: 'Clave123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'spawneo el compa'),
            new OA\Response(response: 422, description: 'spawneo mal parece'),
        ]
    )]
    public function store(Request $request)
    {
        $datos = $request->validate([
            'rut' => ['required', 'string', 'regex:/^\d{7,8}-[0-9kK]$/', 'unique:usuarios,rut'],
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellido' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => [
                'required', 'string', 'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@ventasfix\.cl$/',
                'unique:usuarios,correo',
            ],
            'contraseña' => ['required', 'string', 'min:6'],
        ], [
            'correo.regex' => 'dale profe coloque bien el correo',
            'rut.regex' => 'y el rut tambien, dale profe',
        ]);

        $datos['contraseña'] = Hash::make($datos['contraseña']);

        $usuario = Usuario::create($datos);

        return response()->json($usuario, 201);
    }

    #[OA\Put(
        path: '/usuarios/{usuario}',
        summary: 'tamo actualizando gratis',
        tags: ['Usuarios'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'usuario', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['rut', 'nombre', 'apellido', 'correo'],
                properties: [
                    new OA\Property(property: 'rut', type: 'string', example: '12345678-9'),
                    new OA\Property(property: 'nombre', type: 'string', example: 'Juan'),
                    new OA\Property(property: 'apellido', type: 'string', example: 'Pérez'),
                    new OA\Property(property: 'correo', type: 'string', example: 'juan.perez@ventasfix.cl'),
                    new OA\Property(property: 'contraseña', type: 'string', example: '(opcional) Clave123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'ya tamo, vuelva nunca'),
            new OA\Response(response: 404, description: 'y ete quien e'),
            new OA\Response(response: 422, description: 'a nose que paso'),
        ]
    )]
    public function update(Request $request, Usuario $usuario)
    {
        $datos = $request->validate([
            'rut' => ['required', 'string', 'regex:/^\d{7,8}-[0-9kK]$/', Rule::unique('usuarios', 'rut')->ignore($usuario->id)],
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellido' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => [
                'required', 'string', 'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@ventasfix\.cl$/',
                Rule::unique('usuarios', 'correo')->ignore($usuario->id),
            ],
            'contraseña' => ['nullable', 'string', 'min:6'],
        ], [
            'correo.regex' => 'dale profe coloque bien el correo',
            'rut.regex' => 'y el rut tambien, dale profe',
        ]);

        if (! empty($datos['contraseña'])) {
            $datos['contraseña'] = Hash::make($datos['contraseña']);
        } else {
            unset($datos['contraseña']);
        }

        $usuario->update($datos);

        return response()->json($usuario);
    }

    #[OA\Delete(
        path: '/usuarios/{usuario}',
        summary: 'aqui se expulsa del clan a la gente',
        tags: ['Usuarios'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'usuario', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'chau pai'),
            new OA\Response(response: 404, description: 'y ete quien e'),
        ]
    )]
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response()->json(['mensaje' => 'se fue este, bien ahi']);
    }
}
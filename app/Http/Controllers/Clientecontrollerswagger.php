<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class ClienteControllerSwagger extends Controller
{
    #[OA\Get(
        path: '/clientes',
        summary: 'Lista a los clientes(hola profe)',
        tags: ['Clientes'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'se listo todo bien (como esta)'),
        ]
    )]
    public function index()
    {
        return response()->json(Cliente::all());
    }

    #[OA\Get(
        path: '/clientes/{cliente}',
        summary: 'Obtiene un cliente ID (yo bien)',
        tags: ['Clientes'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'cliente', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'obtenido con éxito (la verdad)'),
            new OA\Response(response: 404, description: 'no encontrado (en gran parte del codigo)'),
        ]
    )]
    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    #[OA\Post(
        path: '/clientes',
        summary: 'Agrega un nuevo cliente. (coloque cosas como esta)',
        tags: ['Clientes'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['rut_empr', 'rubro', 'razon_social', 'telefono', 'direccion', 'nombre_contacto', 'correo_contacto'],
                properties: [
                    new OA\Property(property: 'rut_empr', type: 'string', example: '76123456-7'),
                    new OA\Property(property: 'rubro', type: 'string', example: 'retail'),
                    new OA\Property(property: 'razon_social', type: 'string', example: 'Comercial Ejemplo Ltda.'),
                    new OA\Property(property: 'telefono', type: 'string', example: '+56912345678'),
                    new OA\Property(property: 'direccion', type: 'string', example: 'Av. Siempre Viva 123'),
                    new OA\Property(property: 'nombre_contacto', type: 'string', example: 'María López'),
                    new OA\Property(property: 'correo_contacto', type: 'string', example: 'maria@comercialejemplo.cl'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Cliente creado con éxito (pero me quede sin ideas)'),
            new OA\Response(response: 422, description: 'Error de validación (y aparte siento que ya repeti mucho)'),
        ]
    )]
    public function store(Request $request)
    {
        $datos = $request->validate([
            'rut_empr' => ['required', 'string', 'regex:/^\d{7,8}-[0-9kK]$/', 'unique:clientes,rut_empr'],
            'rubro' => ['required', Rule::in(Cliente::RUBROS)],
            'razon_social' => ['required', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'nombre_contacto' => ['required', 'string', 'min:2', 'max:150'],
            'correo_contacto' => [
                'required', 'string', 'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
        ], [
            'rut_empr.regex' => 'El rut debe tener el formato 12345678-9 (sin puntos).',
            'correo_contacto.regex' => 'El correo de contacto debe tener un formato válido.',
        ]);

        $cliente = Cliente::create($datos);

        return response()->json($cliente, 201);
    }

    #[OA\Put(
        path: '/clientes/{cliente}',
        summary: 'Actualiza un cliente por su ID.(una cosa)',
        tags: ['Clientes'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'cliente', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['rut_empr', 'rubro', 'razon_social', 'telefono', 'direccion', 'nombre_contacto', 'correo_contacto'],
                properties: [
                    new OA\Property(property: 'rut_empr', type: 'string', example: '76123456-7'),
                    new OA\Property(property: 'rubro', type: 'string', example: 'retail'),
                    new OA\Property(property: 'razon_social', type: 'string', example: 'Comercial Ejemplo Ltda.'),
                    new OA\Property(property: 'telefono', type: 'string', example: '+56912345678'),
                    new OA\Property(property: 'direccion', type: 'string', example: 'Av. Siempre Viva 123'),
                    new OA\Property(property: 'nombre_contacto', type: 'string', example: 'María López'),
                    new OA\Property(property: 'correo_contacto', type: 'string', example: 'maria@comercialejemplo.cl'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Cliente actualizado con éxito (cuando escribo cosas como)'),
            new OA\Response(response: 404, description: 'Cliente no encontrado(eta o pai)'),
            new OA\Response(response: 422, description: 'Error de validación(no es falta de ortografia)'),
        ]
    )]
    public function update(Request $request, Cliente $cliente)
    {
        $datos = $request->validate([
            'rut_empr' => ['required', 'string', 'regex:/^\d{7,8}-[0-9kK]$/', Rule::unique('clientes', 'rut_empr')->ignore($cliente->id)],
            'rubro' => ['required', Rule::in(Cliente::RUBROS)],
            'razon_social' => ['required', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'nombre_contacto' => ['required', 'string', 'min:2', 'max:150'],
            'correo_contacto' => [
                'required', 'string', 'max:150',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
        ], [
            'rut_empr.regex' => 'El rut debe tener el formato 12345678-9 (es solo que queria colocarlo asi)',
            'correo_contacto.regex' => 'El correo de contacto debe tener un formato válido.(y bueno me estoy quedando sin cosas para escribir)',
        ]);

        $cliente->update($datos);

        return response()->json($cliente);
    }

    #[OA\Delete(
        path: '/clientes/{cliente}',
        summary: 'Elimina un cliente por su ID.(asi que)',
        tags: ['Clientes'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'cliente', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Cliente eliminado con éxito(como quiero dejarlo solo para este swagger)'),
            new OA\Response(response: 404, description: 'Cliente no encontrado(si logra ver esto)'),
        ]
    )]
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(['mensaje' => 'Cliente eliminado correctamente.(deje una señal nose como pan con uevo, perdon por estar aburrido haciendo esto)']);
    }
}

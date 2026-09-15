<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class ProductoControllerSwagger extends Controller
{
    #[OA\Get(
        path: '/productos',
        summary: 'aqui esta el stuff',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'aqui eta'),
        ]
    )]
    public function index()
    {
        return response()->json(Producto::all());
    }

    #[OA\Get(
        path: '/productos/{producto}',
        summary: 'dame el id porfa',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'producto', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'efectivamente, aqui esta'),
            new OA\Response(response: 404, description: 'este no eta'),
        ]
    )]
    public function show(Producto $producto)
    {
        return response()->json($producto);
    }

    #[OA\Post(
        path: '/productos',
        summary: 'colocaciona otro item',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['sku', 'nombre', 'descr_corta', 'descr_larga', 'precio_neto', 'stock_actual', 'stock_minimo', 'stock_bajo', 'stock_alto'],
                properties: [
                    new OA\Property(property: 'sku', type: 'string', example: 'PROD-001'),
                    new OA\Property(property: 'nombre', type: 'string', example: 'Mouse inalámbrico'),
                    new OA\Property(property: 'descr_corta', type: 'string', example: 'Mouse ergonómico'),
                    new OA\Property(property: 'descr_larga', type: 'string', example: 'Mouse inalámbrico asi terrible epico con colores apra mas aerodinamismo'),
                    new OA\Property(property: 'precio_neto', type: 'integer', example: 10000),
                    new OA\Property(property: 'stock_actual', type: 'integer', example: 50),
                    new OA\Property(property: 'stock_minimo', type: 'integer', example: 5),
                    new OA\Property(property: 'stock_bajo', type: 'integer', example: 10),
                    new OA\Property(property: 'stock_alto', type: 'integer', example: 100),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'ya esta'),
            new OA\Response(response: 422, description: 'no, no esta'),
        ]
    )]
    public function store(Request $request)
    {

        $datos = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:productos,sku'],
            'nombre' => ['required', 'string', 'max:100'],
            'descr_corta' => ['required', 'string'],
            'descr_larga' => ['required', 'string'],
            'precio_neto' => ['required', 'integer', 'min:1'],
            'stock_actual' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'stock_bajo' => ['required', 'integer', 'min:0'],
            'stock_alto' => ['required', 'integer', 'min:0', 'gte:stock_bajo'],
        ]);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        } else {
            $datos['imagen'] = 'productos/sin-imagen.png';
        }

        $producto = Producto::create($datos);

        return response()->json($producto, 201);
    }

    #[OA\Put(
        path: '/productos/{producto}',
        summary: 'ya se actualizo(la verda profe me quede sin ideas de nuevo)',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'producto', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['sku', 'nombre', 'descr_corta', 'descr_larga', 'precio_neto', 'stock_actual', 'stock_minimo', 'stock_bajo', 'stock_alto'],
                properties: [
                    new OA\Property(property: 'sku', type: 'string', example: 'PROD-001'),
                    new OA\Property(property: 'nombre', type: 'string', example: 'Mouse inalámbrico'),
                    new OA\Property(property: 'descr_corta', type: 'string', example: 'Mouse ergonómico'),
                    new OA\Property(property: 'descr_larga', type: 'string', example: 'Mouse inalámbrico con diseño ergonómico'),
                    new OA\Property(property: 'precio_neto', type: 'integer', example: 10000),
                    new OA\Property(property: 'stock_actual', type: 'integer', example: 50),
                    new OA\Property(property: 'stock_minimo', type: 'integer', example: 5),
                    new OA\Property(property: 'stock_bajo', type: 'integer', example: 10),
                    new OA\Property(property: 'stock_alto', type: 'integer', example: 100),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'se actualizo, bien ahi'),
            new OA\Response(response: 404, description: 'no esta'),
            new OA\Response(response: 422, description: 'Error en algo'),
        ]
    )]
    public function update(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'sku' => ['required', 'string', 'max:50', Rule::unique('productos', 'sku')->ignore($producto->id)],
            'nombre' => ['required', 'string', 'max:100'],
            'descr_corta' => ['required', 'string'],
            'descr_larga' => ['required', 'string'],
            'precio_neto' => ['required', 'integer', 'min:1'],
            'stock_actual' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'stock_bajo' => ['required', 'integer', 'min:0'],
            'stock_alto' => ['required', 'integer', 'min:0', 'gte:stock_bajo'],
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($datos);

        return response()->json($producto);
    }

    #[OA\Delete(
        path: '/productos/{producto}',
        summary: 'Elimina un producto por su ID.',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'producto', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Producto eliminado con éxito'),
            new OA\Response(response: 404, description: 'Producto no encontrado'),
        ]
    )]
    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json(['mensaje' => 'Producto eliminado correctamente.']);
    }
}

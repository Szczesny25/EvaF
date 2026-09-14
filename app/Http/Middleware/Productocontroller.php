<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->paginate(10);

        return view('productos.index', compact('productos'));
    }

    public function crear()
    {
        return view('productos.crear');
    }

    public function guardar(Request $request)
    {
        $datos = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:productos,sku'],
            'nombre' => ['required', 'string', 'max:100'],
            'descr_corta' => ['required', 'string'],
            'descr_larga' => ['required', 'string'],
            'imagen' => ['required', 'image', 'max:2048'],
            'precio_neto' => ['required', 'integer', 'min:1'],
            'stock_actual' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'stock_bajo' => ['required', 'integer', 'min:0'],
            'stock_alto' => ['required', 'integer', 'min:0', 'gte:stock_bajo'],
        ]);

        $datos['imagen'] = $request->file('imagen')->store('productos', 'public');

        Producto::create($datos);

        return redirect()->route('productos.index')->with('bebe, lo logramos', 'spawneo el objeto');
    }

    public function editar(Producto $producto)
    {
        return view('productos.editar', compact('producto'));
    }

    public function actualizar(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'sku' => ['required', 'string', 'max:50', Rule::unique('productos', 'sku')->ignore($producto->id)],
            'nombre' => ['required', 'string', 'max:100'],
            'descr_corta' => ['required', 'string'],
            'descr_larga' => ['required', 'string'],
            'imagen' => ['nullable', 'image', 'max:2048'],
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
        } else {
            unset($datos['imagen']);
        }

        $producto->update($datos);

        return redirect()->route('productos.index')->with('exito', 'nose ya me quede sin ideas profe, se actualizo esta vaina');
    }

    public function eliminar(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('vamooo', 'se elimino :D (o si es algo malo D:)');
    }
}
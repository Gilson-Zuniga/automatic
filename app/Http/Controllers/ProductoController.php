<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\TipoArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $perPage = $request->input('perPage', 10);

        $productos = Producto::with(['proveedor', 'categoria', 'tipoArticulo'])
            ->when($buscar, function ($query, $buscar) {
                $query->where('id', $buscar)
                    ->orWhere('nombre', 'like', "%$buscar%");
                    // Nota: ya no se busca por "categoria" como texto.
            })
            ->latest()
            ->paginate($perPage)
            ->appends(['buscar' => $buscar, 'perPage' => $perPage]);

        $proveedores = Proveedor::all();
        $categorias = Categoria::all();
        $tiposArticulos = TipoArticulo::all();

        return view('productos.index', compact('productos', 'proveedores', 'categorias', 'tiposArticulos', 'buscar', 'perPage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_articulo_id' => 'required|exists:tipo_articulos,id',
            'descripcion' => 'nullable|string',
            'proveedor_nit' => 'required|exists:proveedores,nit',
            'foto' => 'nullable|image|max:2048',
        ]);

        $datos = $request->only([
            'nombre', 'precio', 'categoria_id', 'tipo_articulo_id',
            'descripcion', 'proveedor_nit'
        ]);

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('productos', 'public');
        }

        Producto::create($datos);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');

    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_articulo_id' => 'required|exists:tipo_articulos,id',
            'descripcion' => 'nullable|string',
            'proveedor_nit' => 'required|exists:proveedores,nit',
            'foto' => 'nullable|image|max:2048',
        ]);

        $datos = $request->only([
            'nombre', 'precio', 'categoria_id', 'tipo_articulo_id', 
            'descripcion', 'proveedor_nit'
        ]);

        if ($request->hasFile('foto')) {
            if ($producto->foto && Storage::disk('public')->exists($producto->foto)) {
                Storage::disk('public')->delete($producto->foto);
            }
            $datos['foto'] = $request->file('foto')->store('productos', 'public');
        }

        $producto->update($datos);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->foto && Storage::disk('public')->exists($producto->foto)) {
            Storage::disk('public')->delete($producto->foto);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}

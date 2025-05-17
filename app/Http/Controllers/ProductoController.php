<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('proveedor')->get();
        $proveedores = Proveedor::all();
        return view('productos.index', compact('productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'categoria' => 'required|string|max:255',
            'tipo_articulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedor_nit' => 'required|exists:proveedores,nit',
            'foto' => 'nullable|image|max:2048',
        ]);

        $datos = $request->all();

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('productos', 'public');
        }

        Producto::create($datos);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'categoria' => 'required|string|max:255',
            'tipo_articulo' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'proveedor_nit' => 'required|exists:proveedores,nit',
            'foto' => 'nullable|image|max:2048',
        ]);

        $datos = $request->all();

        if ($request->hasFile('foto')) {
            // Elimina imagen anterior si existe
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

<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
{
    $query = Catalogo::with(['producto', 'proveedor']);

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query  ->where('id', $search)
                ->orWhere('proveedor_nit', 'like', "%$search%")
                ->orWhereHas('producto', fn($q) => $q->where('nombre', 'like', "%$search%"))
                ->orWhere('categoria_id', $search)
                ->orWhere('tipo_articulo_id', $search);
    }

    $catalogos = $query->paginate(10);

    return view('catalogo.index', compact('catalogos'));
}

    public function create()
    {
        $inventarioDisponible = Inventario::with('producto')
            ->where('cantidad', '>', 0)
            ->get();

        return view('catalogo.create', compact('inventarioDisponible'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'proveedor_nit' => 'required|exists:proveedores,nit',
            'cantidad' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        Catalogo::create([
            'producto_id' => $request->producto_id,
            'proveedor_nit' => $request->proveedor_nit,
            'cantidad' => $request->cantidad,
            'categoria_id' => $producto->categoria_id,
            'tipo_articulo_id' => $producto->tipo_articulo_id,
            'foto' => $producto->foto,
            'valor' => $request->valor,
            'descuento' => $request->descuento,
        ]);

        return redirect()->route('catalogo.index')->with('success', 'Producto agregado al catálogo.');
    }

    public function edit(Catalogo $catalogo)
    {
        return view('catalogo.edit', compact('catalogo'));
    }

    public function update(Request $request, Catalogo $catalogo)
    {
        $request->validate([
            'valor' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        $catalogo->update([
            'valor' => $request->valor,
            'descuento' => $request->descuento,
        ]);

        return redirect()->route('catalogo.index')->with('success', 'Catálogo actualizado.');
    }

    public function destroy(Catalogo $catalogo)
    {
        $catalogo->delete();

        return redirect()->route('catalogo.index')->with('success', 'Item eliminado del catálogo.');
    }
}

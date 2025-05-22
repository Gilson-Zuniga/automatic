<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoArticulo;
use App\Models\Categoria;

class TipoArticuloController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);
        $buscar = $request->get('buscar');

        $query = TipoArticulo::with('categoria')->latest();

        if ($buscar) {
            $query->where('nombre', 'like', "%$buscar%")
                ->orWhereHas('categoria', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%$buscar%");
                });
        }

        $tipoArticulos = $query->paginate($perPage);
        $categorias = Categoria::all();

        return view('tipoArticulos.index', compact('tipoArticulos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        TipoArticulo::create($request->only('nombre', 'categoria_id'));

        return redirect()->back()->with('success', 'Tipo de artículo registrado.');
    }

    public function update(Request $request, TipoArticulo $tipoArticulo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $tipoArticulo->update($request->only('nombre', 'categoria_id'));

        return redirect()->route('tipoArticulos.index')->with('success', 'Tipo de artículo actualizado.');
    }

    public function destroy(TipoArticulo $tipoArticulo)
    {
        $tipoArticulo->delete();

        return redirect()->back()->with('success', 'Tipo de artículo eliminado.');
    }
}

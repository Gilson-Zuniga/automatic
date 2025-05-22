<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\TipoArticulo;


class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('tipoArticulos')->orderBy('nombre')->paginate(10); // <-- paginate aquí
    return view('categorias.index', compact('categorias'));
    }

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipos_articulos' => 'required|array|min:1',
        'tipos_articulos.*' => 'required|string|max:255',
    ]);

    $categoria = Categoria::create([
        'nombre' => $request->nombre,
    ]);

    if ($request->has('tipos_articulos')) {
        foreach ($request->tipos_articulos as $tipo) {
            $tipos= array_map('trim', explode(',', $tipo));

            foreach ($tipos as $tipoNombre) {
                if(!empty($tipoNombre)){
                    
                TipoArticulo::create([
                    'nombre' => $tipoNombre,
                    'categoria_id' => $categoria->id,
                ]);
            }
        }
        }
    }

    return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito');
}

    public function update(Request $request, Categoria $categoria)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipos_articulos' => 'nullable|array',
        'tipos_articulos.*' => 'required|string|max:255',
        'tipos_articulos_id' => 'nullable|array',
        'tipos_articulos_id.*' => 'nullable|integer|exists:tipo_articulos,id',
    ]);

    // Actualizar categoría
    $categoria->nombre = $request->nombre;
    $categoria->save();

    $tipos_nombres = $request->input('tipos_articulos', []);
    $tipos_ids = $request->input('tipos_articulos_id', []);

    // IDs que se mantendrán
    $ids_enviar = collect($tipos_ids)->filter()->all();

    // Eliminar tipos que ya no están en el formulario
    $categoria->tipoArticulos()->whereNotIn('id', $ids_enviar)->delete();

    // Actualizar o crear tipos de artículo
    foreach ($tipos_nombres as $index => $nombre) {
        $tipo_id = $tipos_ids[$index] ?? null;

        if ($tipo_id) {
            // Actualizar existente
            $tipo = TipoArticulo::find($tipo_id);
            if ($tipo) {
                $tipo->nombre = $nombre;
                $tipo->save();
            }
        } else {
            // Crear nuevo
            $categoria->tipoArticulos()->create([
                'nombre' => $nombre,
            ]);
        }
    }

    return redirect()->route('categorias.index')->with('success', 'Categoría y tipos de artículo actualizados.');
}




    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->back()->with('success', 'Categoría eliminada.');
    }
}

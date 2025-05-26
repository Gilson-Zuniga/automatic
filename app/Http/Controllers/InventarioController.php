<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventario::with(['producto', 'proveedor']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->whereHas('producto', function ($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%');
            })->orWhereHas('proveedor', function ($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%')
                ->orWhere('nit', 'like', '%' . $buscar . '%');
            });
        }

        $inventario = $query->paginate(10);

        return view('inventario.index', compact('inventario'));
    }
}

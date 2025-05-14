<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Mostrar todos los proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Guardar nuevo proveedor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nit' => 'required|string|max:20|unique:proveedores,nit',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:50',
            'ciudad' => 'required|string|max:100',
            'rut' => 'required|string|max:255',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')
                            ->with('success', 'Proveedor registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($nit)
    {
        $proveedor = Proveedor::findOrFail($nit);
        return view('proveedores.create', compact('proveedor'));
    }

    /**
     * Actualizar proveedor.
     */
    public function update(Request $request, $nit)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:50',
            'ciudad' => 'required|string|max:100',
            'rut' => 'required|string|max:255',
        ]);

        $proveedor = Proveedor::findOrFail($nit);
        $proveedor->update($request->except('nit')); // nit no se actualiza

        return redirect()->route('proveedores.index')
                            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Eliminar proveedor.
     */
    public function destroy($nit)
    {
        $proveedor = Proveedor::findOrFail($nit);
        $proveedor->delete();

        return redirect()->route('proveedores.index')
                         ->with('success', 'Proveedor eliminado correctamente.');
    }
}

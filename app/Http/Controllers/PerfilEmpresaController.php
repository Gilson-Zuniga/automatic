<?php
namespace App\Http\Controllers;
use App\Models\FacturaProveedor;
use App\Models\FacturaProveedorItem;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\PerfilEmpresa;
use Illuminate\Http\Request;

class PerfilEmpresaController extends Controller
{
    public function index()
    {
        $empresas = PerfilEmpresa::paginate(10);
        return view('perfilEmpresas.index', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nit' => 'required|string|unique:perfil_empresas,nit',
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'ciudad' => 'required|string',
        ]);

        PerfilEmpresa::create($request->all());

        return redirect()->route('perfilEmpresas.index')->with('success', 'Empresa registrada correctamente.');
    }

    public function update(Request $request, $nit)
    {
        $empresa = PerfilEmpresa::findOrFail($nit);

        $request->validate([
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'ciudad' => 'required|string',
        ]);

        $empresa->update($request->all());

        return redirect()->route('perfilEmpresas.index')->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy($nit)
    {
        $empresa = PerfilEmpresa::findOrFail($nit);
        $empresa->delete();

        return redirect()->route('perfilEmpresas.index')->with('success', 'Empresa eliminada.');
    }
}

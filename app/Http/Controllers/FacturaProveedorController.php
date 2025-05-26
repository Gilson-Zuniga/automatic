<?php

namespace App\Http\Controllers;

use App\Models\FacturaProveedor;
use App\Models\FacturaProveedorItem;
use App\Models\Proveedor;
use App\Models\PerfilEmpresa;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaProveedorController extends Controller
{
    public function index()
    {
        $facturas = FacturaProveedor::with('proveedor')->latest()->paginate(10);
        return view('facturas_proveedores.index', compact('facturas'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $clientes = PerfilEmpresa::all();
        $productos = Producto::all();
        return view('facturas_proveedores.create', compact('proveedores', 'clientes', 'productos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'numero_factura' => 'required|unique:facturas_proveedores',
        'fecha' => 'required|date',
        'proveedor_nit' => 'required',
        'cliente_nit' => 'required',
        'items_json' => 'required|string', // Validamos que venga el JSON
    ]);

    $items = json_decode($request->items_json, true);

    if (!is_array($items) || count($items) === 0) {
        return back()->withInput()->with('error', 'No se recibieron ítems válidos.');
    }

    DB::transaction(function () use ($request, $items) {
        $factura = FacturaProveedor::create([
            'numero_factura' => $request->numero_factura,
            'fecha' => $request->fecha,
            'proveedor_nit' => $request->proveedor_nit,
            'cliente_nit' => $request->cliente_nit,
            'total' => 0,
        ]);

        $total = 0;

        foreach ($items as $item) {
            if (!isset($item['producto_id'], $item['cantidad'], $item['precio_unitario'], $item['impuesto'])) {
                continue; // Ignorar ítems incompletos
            }

            $cantidad = floatval($item['cantidad']);
            $precio = floatval($item['precio_unitario']);
            $impuesto = floatval($item['impuesto']);
            $subtotal = ($cantidad * $precio) + $impuesto;

            FacturaProveedorItem::create([
                'factura_id' => $factura->id,
                'proveedor_nit' => $factura->proveedor_nit,
                'producto_id' => $item['producto_id'],
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'impuesto' => $impuesto,
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }

        $factura->update(['total' => $total]);

        // Generar PDF
        $pdf = Pdf::loadView('facturas_proveedores.pdf', ['factura' => $factura->load('items.producto')]);
        $path = 'facturas/pdf/factura_' . $factura->id . '.pdf';
        $pdf->save(public_path($path));
        $factura->update(['pdf_path' => $path]);
    });

    return redirect()->route('facturas_proveedores.index')->with('success', 'Factura creada correctamente');
}


    public function edit(FacturaProveedor $factura)
    {
        $proveedores = Proveedor::all();
        $clientes = PerfilEmpresa::all();
        $productos = Producto::all();
        $factura->load('items');
        return view('facturas_proveedores.edit', compact('factura', 'proveedores', 'clientes', 'productos'));
    }

    public function update(Request $request, FacturaProveedor $factura)
    {
        // Similar al store(), con validaciones y actualización de items
    }

    public function destroy(FacturaProveedor $factura)
{
    // Eliminar primero los ítems relacionados
    $factura->items()->delete(); // Asegúrate de tener la relación definida en el modelo

    // Luego eliminar la factura
    $factura->delete();

    return response()->json(['success' => true]);
}


    public function show(FacturaProveedor $factura)
    {
        $factura->load('items.producto', 'proveedor', 'cliente');
        return view('facturas_proveedores.show', compact('factura'));
    }

    public function downloadPdf(FacturaProveedor $factura)
    {
        if ($factura->pdf_path && file_exists(public_path($factura->pdf_path))) {
            return response()->download(public_path($factura->pdf_path));
        }

        abort(404, 'PDF no encontrado');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FacturaVenta;
use App\Models\FacturaVentaItem;
use App\Models\PerfilEmpresa;
use App\Models\Catalogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaVentaController extends Controller
{
    public function index()
    {
        $facturas = FacturaVenta::with('empresa')->latest()->paginate(10);
        return view('facturas_ventas.index', compact('facturas'));
    }

    public function create()
    {
        $productos = \App\Models\Producto::with('catalogo')->get();

        $catalogo = $productos->map(function ($p) {
            return [
                'id' => $p->id,
                'valor' => $p->catalogo->valor ?? 0,
                'descuento' => $p->catalogo->descuento ?? 0,
                'cantidad' => $p->catalogo->cantidad ?? 0,
                'producto' => [
                    'id' => $p->id,
                    'nombre' => $p->nombre,
                ],
            ];
        });

        $empresas = PerfilEmpresa::all();

        return view('facturas_ventas.create', [
            'productos' => $productos,
            'empresas' => $empresas,
            'catalogo' => $catalogo->values(),
        ]);
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'empresa_id' => 'required|exists:perfil_empresas,nit',
            'items_json' => 'required|string',
        ]);

        $items = json_decode($request->items_json, true);
        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->withInput()->with('error', 'Debe agregar al menos un ítem a la factura.');
        }

        DB::beginTransaction();

        try {
            $factura = FacturaVenta::create([
                'empresa_id' => $request->empresa_id,
                'fecha' => now()->toDateString(),
                'hora' => now()->format('H:i:s'),
                'total' => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $catalogo = Catalogo::where('producto_id', $item['producto_id'])->first();

                if (!$catalogo) {
                    throw new \Exception("Producto ID {$item['producto_id']} no existe en el catálogo.");
                }

                if ($catalogo->cantidad < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$catalogo->producto->nombre}");
                }

                $precio_unitario = $item['precio_unitario'];
                $descuento = $item['descuento'] ?? 0;
                $cantidad = $item['cantidad'];
                $impuesto = $item['impuesto'] ?? 0;

                $subtotal = ($precio_unitario - $descuento) * $cantidad + $impuesto;
                $total += $subtotal;

                FacturaVentaItem::create([
                    'factura_venta_id' => $factura->id,
                    'producto_id' => $catalogo->producto_id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio_unitario,
                    'descuento' => $descuento,
                    'impuesto' => $impuesto,
                    'subtotal' => $subtotal,
                ]);

                // Descontar del inventario
                $catalogo->cantidad -= $cantidad;
                $catalogo->save();
            }

            $factura->total = $total;
            $factura->pdf = "facturas/pdf/factura_venta_{$factura->id}.pdf";
            $factura->save();

            $pdf = Pdf::loadView('facturas_ventas.pdf', ['factura' => $factura->load('items.producto', 'empresa')]);
            $pdf->save(public_path($factura->pdf));

            DB::commit();
            return redirect()->route('facturas_ventas.index')->with('success', 'Factura registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error al guardar la factura: ' . $e->getMessage());
        }
    }

    public function show(FacturaVenta $factura)
    {
        $factura->load('empresa', 'items.producto');
        return view('facturas_ventas.show', compact('factura'));
    }

    public function descargarPDF(FacturaVenta $factura)
    {
        if (!$factura->pdf || !file_exists(public_path($factura->pdf))) {
            return redirect()->back()->with('error', 'PDF no encontrado.');
        }

        return response()->download(public_path($factura->pdf));
    }
}

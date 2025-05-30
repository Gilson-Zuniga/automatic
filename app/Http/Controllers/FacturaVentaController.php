<?php

namespace App\Http\Controllers;

use App\Models\FacturaVenta;
use App\Models\FacturaVentaItem;
use App\Models\PerfilEmpresa;
use App\Models\Producto;
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
        $productos = Producto::with('catalogo')->get();

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

        // PASAMOS $catalogo COMO COLECCIÓN (NO JSON) para que Blade haga @json($catalogo)
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
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $factura = FacturaVenta::create([
                'empresa_id' => $request->empresa_id,
                'fecha' => now(),
                'hora' => now()->format('H:i:s'),
                'total' => 0, // se calculará abajo
            ]);

            $total = 0;

            foreach ($request->items as $itemData) {
                $catalogo = Catalogo::where('producto_id', $itemData['producto_id'])->first();

                if (!$catalogo) {
                    throw new \Exception("Producto ID {$itemData['producto_id']} no existe en el catálogo.");
                }

                if ($catalogo->cantidad < $itemData['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$catalogo->producto->nombre}");
                }

                $precio_unitario = $catalogo->valor;
                $descuento = $catalogo->descuento ?? 0;
                $cantidad = $itemData['cantidad'];
                $impuesto = $itemData['impuesto'] ?? 0;

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

                // Descontar del catálogo
                $catalogo->cantidad -= $cantidad;
                $catalogo->save();
            }

            // Generar PDF
            $factura->total = $total;
            $factura->pdf = "facturas/pdf/factura_venta_{$factura->id}.pdf";
            $factura->save();

            $pdf = Pdf::loadView('facturas_ventas.pdf', ['factura' => $factura->load('items.producto', 'empresa')]);
            $pdf->save(public_path($factura->pdf));

            DB::commit();
            return redirect()->route('facturas_ventas.index')->with('success', 'Factura registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
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

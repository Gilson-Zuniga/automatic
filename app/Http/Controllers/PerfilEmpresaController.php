<?php

namespace App\Http\Controllers;

use App\Models\FacturaProveedorItem;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\PerfilEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FacturaProveedorController extends Controller
{
    public function index()
    {
        $facturas = FacturaProveedor::with(['proveedor', 'cliente'])
            ->orderBy('fecha', 'desc')
            ->paginate(10);
            
        return view('facturas-proveedores.index', compact('facturas'));
    }

    public function createModal()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $miEmpresa = PerfilEmpresa::first();
        
        if (!$miEmpresa) {
            return response()->json([
                'success' => false,
                'message' => 'Debe configurar el perfil de la empresa primero'
            ], 400);
        }
        
        return response()->json([
            'success' => true,
            'modal' => view('facturas-proveedores.create', compact('proveedores', 'productos', 'miEmpresa'))->render()
        ]);
    }

    public function showModal(FacturaProveedor $facturaProveedor)
    {
        $factura = $facturaProveedor->load(['proveedor', 'cliente', 'items.producto']);
        
        return response()->json([
            'success' => true,
            'modal' => view('facturas-proveedores.show', compact('factura'))->render()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_nit' => 'required|exists:proveedores,nit',
            'numero_factura' => 'required|unique:facturas_proveedores',
            'fecha' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.impuesto' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            $factura = FacturaProveedor::create([
                'proveedor_nit' => $request->proveedor_nit,
                'cliente_nit' => $request->cliente_nit,
                'numero_factura' => $request->numero_factura,
                'fecha' => $request->fecha,
                'total' => 0
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $impuesto = $subtotal * $item['impuesto'];
                $totalItem = $subtotal + $impuesto;
                
                FacturaProveedorItem::create([
                    'factura_proveedor_id' => $factura->id,
                    'proveedor_nit' => $request->proveedor_nit,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'impuesto' => $item['impuesto'],
                    'subtotal' => $totalItem
                ]);
                
                $total += $totalItem;
            }
            
            $factura->update(['total' => $total]);
            $this->generatePdf($factura->fresh());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Factura creada correctamente',
                'reload' => true
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear factura: '.$e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la factura: '.$e->getMessage()
            ], 500);
        }
    }

    public function download(FacturaProveedor $facturaProveedor)
    {
        try {
            if (!$facturaProveedor->pdf_path || !Storage::exists($facturaProveedor->pdf_path)) {
                $this->generatePdf($facturaProveedor->load(['proveedor', 'cliente', 'items.producto']));
            }

            return Storage::download(
                $facturaProveedor->pdf_path,
                'factura_'.$facturaProveedor->numero_factura.'.pdf',
                ['Content-Type' => 'application/pdf']
            );
            
        } catch (\Exception $e) {
            Log::error('PDF Error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al descargar el PDF'
            ], 500);
        }
    }

    protected function generatePdf(FacturaProveedor $factura)
    {
        $pdf = Pdf::loadView('facturas-proveedores.pdf', [
            'factura' => $factura->load(['proveedor', 'cliente', 'items.producto'])
        ]);
        
        $filename = 'facturas/'.$factura->numero_factura.'.pdf';
        Storage::put($filename, $pdf->output());
        $factura->update(['pdf_path' => $filename]);
        
        return $pdf;
    }
}
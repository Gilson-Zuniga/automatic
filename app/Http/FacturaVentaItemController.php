<?php

namespace App\Http\Controllers;

use App\Models\FacturaVentaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FacturaVentaItemController extends Controller
{
    /**
     * Almacenar un nuevo ítem en una factura de venta
     */
    public function store(Request $request)
    {
        $request->validate([
            'factura_venta_id' => 'required|exists:facturas_ventas,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
            'impuesto' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Creamos el ítem. La lógica del cálculo está en el modelo FacturaVentaItem
            FacturaVentaItem::create($request->all());

            DB::commit();

            return back()->with('success', 'Ítem agregado correctamente a la factura.');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al agregar el ítem: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un ítem de la factura de venta
     */
    public function destroy(FacturaVentaItem $item)
    {
        try {
            $item->delete();

            return back()->with('success', 'Ítem eliminado correctamente y stock restaurado.');
        } catch (Exception $e) {
            return back()->with('error', 'Error al eliminar el ítem: ' . $e->getMessage());
        }
    }
}

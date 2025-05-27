<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\FacturaVenta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class FacturaVentaItem extends Model
{
    protected $table = 'factura_venta_items';

    protected $fillable = [
        'factura_venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'descuento',
        'impuesto',
        'subtotal',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function facturaVenta()
    {
        return $this->belongsTo(FacturaVenta::class);
    }

    protected static function booted()
    {
        // Al crear un ítem
        static::creating(function ($item) {
            $catalogo = \App\Models\Catalogo::where('producto_id', $item->producto_id)->first();

            if ($catalogo) {
                // Verificar stock suficiente
                if ($catalogo->cantidad < $item->cantidad) {
                    throw new \Exception("Stock insuficiente en catálogo para el producto seleccionado.");
                }

                // Completar automáticamente el precio si no se asignó
                if (empty($item->precio_unitario)) {
                    $item->precio_unitario = $catalogo->valor;
                }

                // Completar automáticamente el descuento desde catálogo
                if (empty($item->descuento)) {
                    $item->descuento = $catalogo->descuento ?? 0;
                }

                // Calcular subtotal = (precio - descuento) * cantidad + impuesto
                $base = ($item->precio_unitario - $item->descuento) * $item->cantidad;
                $item->subtotal = $base + ($item->impuesto ?? 0);

                // Descontar cantidad del catálogo
                $catalogo->cantidad -= $item->cantidad;
                $catalogo->cantidad = max(0, $catalogo->cantidad);
                $catalogo->save();
            } else {
                throw new \Exception("Producto no encontrado en el catálogo.");
            }
        });

        // Al eliminar: restaurar cantidad en catálogo
        static::deleted(function ($item) {
            $catalogo = \App\Models\Catalogo::where('producto_id', $item->producto_id)->first();

            if ($catalogo) {
                $catalogo->cantidad += $item->cantidad;
                $catalogo->save();
            }
        });
    }
}

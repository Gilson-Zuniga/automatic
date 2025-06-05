<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacturaClienteItem extends Model
{
    use HasFactory;

    protected $table = 'factura_cliente_items';

    protected $fillable = [
        'factura_cliente_id',
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

    public function factura()
    {
        return $this->belongsTo(FacturaCliente::class, 'factura_cliente_id');
    }

    protected static function booted()
    {
        static::creating(function ($item) {
            $catalogo = \App\Models\Catalogo::where('producto_id', $item->producto_id)->first();
            $inventario = \App\Models\Inventario::where('producto_id', $item->producto_id)->first();

            if (!$catalogo || !$inventario) {
                throw new \Exception("El producto no existe en catálogo o inventario.");
            }

            if ($catalogo->cantidad < $item->cantidad || $inventario->cantidad < $item->cantidad) {
                throw new \Exception("Stock insuficiente en catálogo o inventario para el producto seleccionado.");
            }

            // Asignar valores por defecto si no vienen
            if (empty($item->precio_unitario)) {
                $item->precio_unitario = $catalogo->valor;
            }

            if (empty($item->descuento)) {
                $item->descuento = $catalogo->descuento ?? 0;
            }

            $base = ($item->precio_unitario - $item->descuento) * $item->cantidad;
            $item->subtotal = $base + ($item->impuesto ?? 0);

            // Descontar del catálogo
            $catalogo->cantidad -= $item->cantidad;
            $catalogo->save();

            // Descontar del inventario
            $inventario->cantidad -= $item->cantidad;
            $inventario->save();
        });

        static::deleted(function ($item) {
            $catalogo = \App\Models\Catalogo::where('producto_id', $item->producto_id)->first();
            $inventario = \App\Models\Inventario::where('producto_id', $item->producto_id)->first();

            if ($catalogo) {
                $catalogo->cantidad += $item->cantidad;
                $catalogo->save();
            }

            if ($inventario) {
                $inventario->cantidad += $item->cantidad;
                $inventario->save();
            }
        });
    }
}

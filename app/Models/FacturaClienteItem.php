<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\FacturaCliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

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

            if ($catalogo) {
                if ($catalogo->cantidad < $item->cantidad) {
                    throw new \Exception("Stock insuficiente en catálogo para el producto seleccionado.");
                }

                if (empty($item->precio_unitario)) {
                    $item->precio_unitario = $catalogo->valor;
                }

                if (empty($item->descuento)) {
                    $item->descuento = $catalogo->descuento ?? 0;
                }

                $base = ($item->precio_unitario - $item->descuento) * $item->cantidad;
                $item->subtotal = $base + ($item->impuesto ?? 0);

                $catalogo->cantidad = max(0, $catalogo->cantidad - $item->cantidad);
                $catalogo->save();
            } else {
                throw new \Exception("Producto no encontrado en el catálogo.");
            }
        });

        static::deleted(function ($item) {
            $catalogo = \App\Models\Catalogo::where('producto_id', $item->producto_id)->first();

            if ($catalogo) {
                $catalogo->cantidad += $item->cantidad;
                $catalogo->save();
            }
        });
    }
}

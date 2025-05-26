<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacturaProveedorItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id',
        'proveedor_nit',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'impuesto',
        'subtotal',
    ];

    public function factura()
    {
        return $this->belongsTo(FacturaProveedor::class, 'factura_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}

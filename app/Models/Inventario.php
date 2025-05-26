<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'precio_unitario',
        'proveedor_nit',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_nit', 'nit');
    }
    public function facturaProveedorItems()
    {
        return $this->hasMany(FacturaProveedorItem::class, 'producto_id', 'producto_id')
                    ->where('proveedor_nit', $this->proveedor_nit);
    }

}

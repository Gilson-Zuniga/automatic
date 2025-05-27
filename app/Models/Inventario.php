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

    protected static function booted()
    {
        // Al crear un inventario, crear o actualizar catálogo con datos de producto
        static::created(function ($inventario) {
            $producto = $inventario->producto;

            if (!$producto) return;

            $catalogo = \App\Models\Catalogo::firstOrNew([
                'producto_id' => $inventario->producto_id,
                'proveedor_nit' => $inventario->proveedor_nit,
            ]);

            $catalogo->foto = $producto->foto ?? null;
            $catalogo->categoria_id = $producto->categoria_id ?? null;
            $catalogo->tipo_articulo_id = $producto->tipo_articulo_id ?? null;
            $catalogo->cantidad = $inventario->cantidad;
            $catalogo->valor = $catalogo->valor ?? $inventario->precio_unitario ?? 0;
            $catalogo->descuento = $catalogo->descuento ?? 0;

            $catalogo->save();
        });

        // Al actualizar un inventario, actualizar datos relacionados en catálogo (foto, categoría, tipo_articulo, cantidad)
        static::updated(function ($inventario) {
            $producto = $inventario->producto;

            if (!$producto) return;

            $catalogo = \App\Models\Catalogo::where('producto_id', $inventario->producto_id)
                ->where('proveedor_nit', $inventario->proveedor_nit)
                ->first();

            if ($catalogo) {
                $catalogo->foto = $producto->foto ?? $catalogo->foto;
                $catalogo->categoria_id = $producto->categoria_id ?? $catalogo->categoria_id;
                $catalogo->tipo_articulo_id = $producto->tipo_articulo_id ?? $catalogo->tipo_articulo_id;
                $catalogo->cantidad = $inventario->cantidad;
                $catalogo->save();
            }
        });

        // Opcional: al eliminar un inventario, eliminar su catálogo asociado (o manejarlo según tu lógica)
        static::deleted(function ($inventario) {
            $catalogo = \App\Models\Catalogo::where('producto_id', $inventario->producto_id)
                ->where('proveedor_nit', $inventario->proveedor_nit)
                ->first();

            if ($catalogo) {
                $catalogo->delete();
            }
        });
    }
}

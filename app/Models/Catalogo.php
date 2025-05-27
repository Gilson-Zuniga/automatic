<?php

namespace App\Models;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\TipoArticulo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $table = 'catalogo';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'producto_id',
        'proveedor_nit',
        'cantidad',
        'categoria_id',
        'tipo_articulo_id',
        'foto',
        'valor',
        'descuento',
    ];

    /**
     * RELACIONES
     */

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación con el proveedor (clave personalizada)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_nit', 'nit');
    }

    // Relación con la categoría (opcional)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con el tipo de artículo (opcional)
    public function tipoArticulo()
    {
        return $this->belongsTo(TipoArticulo::class);
    }
    

    /**
     * EVENTOS DEL MODELO
     */
    protected static function booted()
    {
        // Al crear un registro del catálogo, restar del inventario
        static::created(function ($catalogo) {
            $inventario = \App\Models\Inventario::where([
                'producto_id' => $catalogo->producto_id,
                'proveedor_nit' => $catalogo->proveedor_nit
            ])->first();

            if ($inventario) {
                $inventario->cantidad -= $catalogo->cantidad;
                $inventario->cantidad = max(0, $inventario->cantidad); // Evitar valores negativos
                $inventario->save();
            }
        });

        // Al eliminar un catálogo, devolver la cantidad al inventario
        static::deleted(function ($catalogo) {
            $inventario = \App\Models\Inventario::where([
                'producto_id' => $catalogo->producto_id,
                'proveedor_nit' => $catalogo->proveedor_nit
            ])->first();

            if ($inventario) {
                $inventario->cantidad += $catalogo->cantidad;
                $inventario->save();
            }
        });
    }
}

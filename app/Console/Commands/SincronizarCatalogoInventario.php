<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventario;
use App\Models\Catalogo;

class SincronizarCatalogoInventario extends Command
{
    protected $signature = 'catalogo:sincronizar';
    protected $description = 'Sincroniza la tabla catalogo con los productos del inventario';

    public function handle()
    {
        $inventarios = Inventario::with('producto')->get();

        foreach ($inventarios as $inventario) {
            if (!$inventario->producto) continue;

            $catalogo = Catalogo::firstOrNew([
                'producto_id' => $inventario->producto_id,
                'proveedor_nit' => $inventario->proveedor_nit,
            ]);

            $catalogo->foto = $inventario->producto->foto ?? null;
            $catalogo->categoria_id = $inventario->producto->categoria_id ?? null;
            $catalogo->tipo_articulo_id = $inventario->producto->tipo_articulo_id ?? null;
            $catalogo->cantidad = $inventario->cantidad;

            if (is_null($catalogo->valor)) {
                $catalogo->valor = $inventario->precio_unitario ?? 0;
            }
            if (is_null($catalogo->descuento)) {
                $catalogo->descuento = 0;
            }

            $catalogo->save();
        }

        $this->info('Sincronización completa.');
    }
}

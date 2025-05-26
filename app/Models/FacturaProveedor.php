<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FacturaProveedor extends Model
{
    protected $table = 'facturas_proveedores';
    use HasFactory;

    protected $fillable = [
        'proveedor_nit',
        'cliente_nit',
        'numero_factura',
        'fecha',
        'total',
        'pdf_path',
    ];
    

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_nit', 'nit');
    }

    public function cliente()
    {
        return $this->belongsTo(PerfilEmpresa::class, 'cliente_nit', 'nit');
    }

    public function items()
    {
        return $this->hasMany(FacturaProveedorItem::class, 'factura_id');
    }
}

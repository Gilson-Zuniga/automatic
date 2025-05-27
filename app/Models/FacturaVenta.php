<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    use HasFactory;

    protected $table = 'facturas_ventas';

    protected $fillable = [
        'empresa_id',
        'numero_factura',
        'fecha',
        'hora'
    ];

    public function empresa()
    {
        return $this->belongsTo(PerfilEmpresa::class, 'empresa_id', 'nit');
    }

    public function items()
    {
        return $this->hasMany(FacturaVentaItem::class, 'factura_id');
    }
}

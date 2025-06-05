<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaCliente extends Model
{
    use HasFactory;

    protected $table = 'facturas_clientes';

    protected $fillable = [
        'empresa_id',
        'numero_factura',
        'total',
        'pdf',
        'created_at',
    ];

    public function empresa()
    {
        return $this->belongsTo(PerfilEmpresa::class, 'empresa_id', 'nit');
    }

    public function items()
    {
        return $this->hasMany(FacturaClienteItem::class, 'factura_cliente_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    /** @use HasFactory<\Database\Factories\ProveedorFactory> */
    use HasFactory;
    protected $fillable = [
        'nit',
        'nombre',
        'direccion',
        'email', 
        'telefono',
        'ciudad',
        'rut'
    ];
    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedor_nit', 'nit');
    }
    protected $primaryKey = 'nit'; // nit como clave primaria
    public $incrementing = false; // no es autoincremental
    protected $keyType = 'string'; // tipo de dato de la clave primaria
    public $timestamps = false; // habilitar timestamps
    protected $table = 'proveedores'; // nombre de la tabla
}

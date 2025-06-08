<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue convención de Laravel)
    protected $table = 'proveedores';

    // Campos asignables masivamente
    protected $fillable = [
        'nit',
        'nombre',
        'direccion',
        'email',
        'telefono',
        'ciudad',
        'rut'
    ];

    // Campos ocultos en arrays
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // Tipos de atributos
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
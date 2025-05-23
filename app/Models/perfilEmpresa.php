<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerfilEmpresa extends Model
{
    use HasFactory;

    protected $table = 'perfil_empresas';
    protected $primaryKey = 'nit';
    public $incrementing = false; //autoincrementable
    protected $keyType = 'string'; // 

    protected $fillable = [
        'nit',
        'nombre',
        'direccion',
        'email',
        'telefono',
        'ciudad',
    ];
}


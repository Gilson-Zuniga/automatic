<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = ['nombre'];
    protected $table = 'categorias'; // nombre de la tabla
    protected $primaryKey = 'id'; // clave primaria
    public $incrementing = true; // es autoincremental      

    public function tipoArticulos()
    {
        return $this->hasMany(TipoArticulo::class);
    }
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function proveedor()
{
    return $this->belongsTo(Proveedor::class, 'proveedor_nit', 'nit');
}

}

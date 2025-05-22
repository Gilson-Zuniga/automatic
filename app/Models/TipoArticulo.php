<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoArticulo extends Model
{
    protected $fillable = ['nombre', 'categoria_id'];
    protected $table = 'tipo_articulos'; // nombre de la tabla
    protected $primaryKey = 'id'; // clave primaria 

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}

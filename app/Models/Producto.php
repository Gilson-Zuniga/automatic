<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proveedor;
use App\Models\TipoArticulo;
use App\Models\Categoria;
use App\Models\FacturaClienteItem;
use App\Models\Catalogo;



class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'precio', 
        'categoria_id',
        'tipo_articulo_id', 
        'foto', 
        'descripcion', 
        'proveedor_nit',
        'foto' 
        ];
        public function proveedor(){
        
            return $this->belongsTo(Proveedor::class, 'proveedor_nit', 'nit');
            }
        public function tipoArticulo(){
        
            return $this->belongsTo(TipoArticulo::class);
            }
        public function categoria(){
        
            return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
            }
            public function catalogo()
                {
                    return $this->hasOne(Catalogo::class, 'producto_id', 'id');
                }
            public function facturaVentaItems()
            {
                return $this->hasMany(FacturaClienteitem::class, 'producto_id', 'id');
            }
    use HasFactory;
    protected $table = 'productos'; // nombre de la tabla
    protected $primaryKey = 'id'; // id como clave primaria
    public $incrementing = true; // es autoincremental
    protected $keyType = 'int'; // tipo de dato de la clave primaria
    public $timestamps = true; // habilitar timestamps
    protected $casts = [
        'precio' => 'decimal:2', // precio como decimal con 2 decimales
    ];
}

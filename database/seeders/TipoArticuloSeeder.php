<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\TipoArticulo;
use Illuminate\Database\Seeder;

class TipoArticuloSeeder extends Seeder
{
    public function run()
    {
        // Tipos predefinidos por categoría
        $tiposPorCategoria = [
            'Electrónica' => ['Smartphones', 'Laptops', 'Tablets', 'Audio', 'Accesorios'],
            'Hogar' => ['Muebles', 'Electrodomésticos', 'Decoración', 'Cocina', 'Iluminación'],
            'Ropa' => ['Camisetas', 'Pantalones', 'Vestidos', 'Chaquetas', 'Ropa interior'],
            'Deportes' => ['Fútbol', 'Baloncesto', 'Ciclismo', 'Fitness', 'Running'],
            'Juguetes' => ['Educativos', 'Figuras de acción', 'Juegos de mesa', 'Peluches', 'Juguetes electrónicos'],
            'Belleza' => ['Cuidado facial', 'Maquillaje', 'Cuidado capilar', 'Fragancias', 'Cuidado corporal'],
            'Herramientas' => ['Herramientas manuales', 'Herramientas eléctricas', 'Ferretería', 'Jardinería', 'Medición'],
            'Libros' => ['Literatura', 'Científicos', 'Autoayuda', 'Infantiles', 'Biografías']
        ];

        foreach ($tiposPorCategoria as $categoriaNombre => $tipos) {
            $categoria = Categoria::where('nombre', $categoriaNombre)->first();
            
            if ($categoria) {
                foreach ($tipos as $tipoNombre) {
                    // Usando el factory pero con nombres específicos
                    TipoArticulo::factory()->create([
                        'nombre' => $tipoNombre,
                        'categoria_id' => $categoria->id
                    ]);
                }
            }
        }

        // Opcional: Crear algunos tipos adicionales aleatorios
        TipoArticulo::factory()->count(10)->create();
    }
}
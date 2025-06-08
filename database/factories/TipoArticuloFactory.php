<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\TipoArticulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoArticuloFactory extends Factory
{
    protected $model = TipoArticulo::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->word,
            'categoria_id' => Categoria::inRandomOrder()->first()->id ?? 
                             Categoria::factory()->create()->id,
        ];
    }
}
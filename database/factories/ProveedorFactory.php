<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition()
    {
        $ciudadesColombia = [
            'Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Cartagena',
            'Bucaramanga', 'Pereira', 'Manizales', 'Armenia', 'Ibagué'
        ];

        return [
            'nit' => $this->faker->unique()->numerify('9########'),
            'nombre' => $this->faker->company(),
            'direccion' => $this->faker->address(),
            'email' => $this->faker->unique()->companyEmail(),
            'telefono' => $this->faker->numerify('3########'),
            'ciudad' => $this->faker->randomElement($ciudadesColombia),
            'rut' => $this->faker->unique()->numerify('########-') . $this->faker->randomDigit(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
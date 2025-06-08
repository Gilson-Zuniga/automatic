<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run()
    {
        // Crear 50 proveedores aleatorios
        Proveedor::factory()->count(50)->create();

        // Crear algunos proveedores específicos (opcional)
        Proveedor::create([
            'nit' => '901234567',
            'nombre' => 'Distribuciones Andinas SAS',
            'direccion' => 'Carrera 45 # 26-85, Bogotá',
            'email' => 'ventas@distribucionesandinas.com',
            'telefono' => '3101234567',
            'ciudad' => 'Bogotá',
            'rut' => '12345678-9'
        ]);

        Proveedor::create([
            'nit' => '987654321',
            'nombre' => 'Tecnologías Modernas LTDA',
            'direccion' => 'Calle 12 # 34-56, Medellín',
            'email' => 'contacto@tecmodernas.com',
            'telefono' => '3209876543',
            'ciudad' => 'Medellín',
            'rut' => '98765432-1'
        ]);
    }
}
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas_proveedores', function (Blueprint $table) {
            $table->id();

            // Columnas de relación
            $table->string('proveedor_nit', 20)->nullable();
            $table->string('cliente_nit', 20)->nullable(); // <-- Usamos cliente_nit, no cliente_id

            // Datos de la factura
            $table->string('numero_factura')->unique();
            $table->date('fecha');
            $table->decimal('total', 15, 2);

            $table->timestamps();

            // Claves foráneas
            $table->foreign('proveedor_nit')->references('nit')->on('proveedores')->onDelete('cascade');
            $table->foreign('cliente_nit')->references('nit')->on('perfil_empresas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas_proveedores');
    }
};

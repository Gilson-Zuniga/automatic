<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('facturas_clientes', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->bigInteger('factura_id');// Numero de factura
            $table->string('empresa_id', 20); // Clave foránea al NIT de perfil_empresas
            $table->decimal('total', 15, 2);
            $table->string('pdf')->nullable();
            $table->timestamps();

            // Clave foránea
            $table->foreign('empresa_id')->references('nit')->on('perfil_empresas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas_clientes');
    }
};

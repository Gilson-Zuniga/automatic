<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad')->default(0);
            $table->decimal('precio_unitario', 10, 2);
            $table->string('proveedor_nit', 20);

            $table->timestamps();

            // Relaciones
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('proveedor_nit')->references('nit')->on('proveedores')->onDelete('cascade');

            // Evitar duplicados por producto y proveedor
            $table->unique(['producto_id', 'proveedor_nit']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};

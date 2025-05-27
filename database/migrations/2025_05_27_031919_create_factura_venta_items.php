<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('factura_venta_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_venta_id'); // FK a facturas_ventas.factura_id
            $table->unsignedBigInteger('producto_id'); // FK a productos.id

            $table->integer('cantidad');
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('impuesto', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2);

            $table->timestamps();

            // Claves foráneas
            $table->foreign('factura_venta_id')->references('factura_id')->on('facturas_ventas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factura_venta_items');
    }
};

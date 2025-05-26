<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factura_proveedor_items', function (Blueprint $table) {
            $table->id();
            $table->string('proveedor_nit', 20)->nullable();
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('impuesto',3,2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('proveedor_nit')->references('nit')->on('proveedores')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_proveedor_items');
    }
};

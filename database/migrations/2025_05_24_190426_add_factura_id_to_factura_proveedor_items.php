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
    Schema::table('factura_proveedor_items', function (Blueprint $table) {
        $table->unsignedBigInteger('factura_id')->after('id');

        $table->foreign('factura_id')
                ->references('id')
                ->on('facturas_proveedores')
                ->onDelete('cascade');
        });
}

public function down(): void
{
    Schema::table('factura_proveedor_items', function (Blueprint $table) {
        $table->dropForeign(['factura_id']);
        $table->dropColumn('factura_id');
    });
}

};

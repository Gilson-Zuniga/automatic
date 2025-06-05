<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('facturas_clientes', function (Blueprint $table) {
            $table->renameColumn('factura_id', 'numero_factura');
            $table->unsignedBigInteger('numero_factura')->change();
            $table->unique('numero_factura');
        });
    }

    public function down(): void
    {
        Schema::table('facturas_clientes', function (Blueprint $table) {
            $table->dropUnique(['numero_factura']);
            $table->renameColumn('numero_factura', 'factura_id');
            $table->bigInteger('factura_id')->change();
        });
    }
};

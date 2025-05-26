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
            $table->decimal('impuesto', 15, 2)->change();
        });
    }


    /**S
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

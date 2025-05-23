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
    Schema::create('perfil_empresas', function (Blueprint $table) {
        $table->string('nit')->primary(); // Clave primaria personalizada, no auto-incrementable
        $table->string('nombre');
        $table->string('direccion');
        $table->string('email')->unique();
        $table->string('telefono');
        $table->string('ciudad');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_empresas');
    }
};

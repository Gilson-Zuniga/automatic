<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // id autoincremental y PK
            $table->string('nombre');
            $table->decimal('precio', 8, 2);
            $table->string('categoria');
            $table->string('foto')->nullable(); // ruta o nombre de la imagen
            $table->text('descripcion')->nullable();

            // Campo proveedor_nit como FK
            $table->string('proveedor_nit');

            $table->timestamps();

            // Foreign key hacia proveedores(nit)
            $table->foreign('proveedor_nit')->references('nit')->on('proveedores')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

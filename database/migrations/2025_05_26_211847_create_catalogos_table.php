<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalogo', function (Blueprint $table) {
            $table->id();

            // Relación con productos
            $table->unsignedBigInteger('producto_id');
            $table->string('proveedor_nit', 20);
            $table->integer('cantidad')->default(0); // Se toma de inventario

            // Campos heredados de productos
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('tipo_articulo_id')->nullable();
            $table->string('foto')->nullable(); // Puedes guardar aquí una ruta a la imagen

            // Campos propios del catálogo
            $table->decimal('valor', 10, 2); // Precio manual que tú defines
            $table->decimal('descuento', 10, 2)->nullable(); // Opcional, puede ser null

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('tipo_articulo_id')->references('id')->on('tipo_articulos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalogo');
    }
};

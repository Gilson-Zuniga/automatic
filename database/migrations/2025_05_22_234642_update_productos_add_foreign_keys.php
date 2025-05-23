<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductosAddForeignKeys extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->after('precio');
            $table->unsignedBigInteger('tipo_articulo_id')->nullable()->after('categoria_id');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('tipo_articulo_id')->references('id')->on('tipo_articulos')->onDelete('cascade');
        });

        // ✅ Solo eliminar si existen
        if (Schema::hasColumn('productos', 'categoria')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('categoria');
            });
        }

        if (Schema::hasColumn('productos', 'tipo_articulo')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('tipo_articulo');
            });
        }
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['tipo_articulo_id']);

            $table->dropColumn('categoria_id');
            $table->dropColumn('tipo_articulo_id');

            $table->string('categoria')->nullable();
            $table->string('tipo_articulo')->nullable();
        });
    }
}

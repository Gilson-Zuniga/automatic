<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->decimal('precio', 10, 2)->change();
    });
}

public function down()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->decimal('precio', 8, 2)->change(); // si era lo original
    });
}

};

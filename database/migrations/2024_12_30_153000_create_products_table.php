<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_Equipo', 100);
            $table->string('subequipo', 100)->nullable();
            $table->string('marca', 100);
            $table->string('modelo', 100);
            $table->integer('unidades_disponible')->default(0);
            $table->integer('stock_critico')->default(0);
            $table->integer('estado_producto')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        if (!Schema::hasTable('restock')) {
            Schema::create('restock', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('producto');
                $table->unsignedBigInteger('usuario');
                $table->date('fecha');
                $table->integer('cant_unidades');
                $table->timestamps();
                $table->softDeletes(); // Borrado lógico
    
                $table->foreign('producto')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
    
    
    public function down(): void
    {
        Schema::dropIfExists('restock');
    }
};

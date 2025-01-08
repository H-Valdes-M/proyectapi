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
    {if (!Schema::hasTable('restock')) {
        Schema::create('restock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto');
            $table->unsignedBigInteger('usuario');
            $table->date('fecha');
            $table->integer('cant_unidades');
            $table->string('coment')->nullable();  // Comentarios (opcional)
            $table->string('doc')->nullable();     // Documento relacionado (opcional)
            $table->tinyInteger('accion')->default(1);
            $table->timestamps();
            $table->softDeletes(); // Borrado lógico

            $table->foreign('producto')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock');
    }
};


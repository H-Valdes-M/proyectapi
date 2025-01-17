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
        Schema::table('shipments', function (Blueprint $table) {
            $table->unsignedBigInteger('doc')->nullable()->after('observacion'); // Agregar columna nullable
            $table->foreign('doc')->references('id')->on('documents')->onDelete('set null'); // Clave foránea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
             // Agregar la columna 'doc' como clave foránea que hace referencia a 'documents'
            $table->unsignedBigInteger('doc')->nullable();
        
            // Agregar la clave foránea que referencia a la tabla 'documents'
            $table->foreign('doc')->references('id')->on('documents')->onDelete('set null');
        });
    }
};

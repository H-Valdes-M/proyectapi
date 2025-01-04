<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('shipments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('usuario'); // Corregido: unsignedBigInteger
        $table->unsignedBigInteger('tribunal'); // Corregido: unsignedBigInteger
        $table->date('fecha');
        $table->string('destinatario', 100);
        $table->string('observacion', 255)->nullable();
        $table->string('guiadeMov', 255)->nullable();
        $table->string('nguiaMov', 50)->nullable();
        $table->timestamps();
        $table->softDeletes(); // Borrado lógico

        // Definición de claves foráneas
        $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('tribunal')->references('id')->on('tribunal')->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};

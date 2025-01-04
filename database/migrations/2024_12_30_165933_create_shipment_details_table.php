<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipment_details', function (Blueprint $table) {
            $table->id(); // ID de detalle de envío
            $table->unsignedBigInteger('id_envio'); // Clave foránea de envío
            $table->unsignedBigInteger('producto'); // Clave foránea de producto
            $table->integer('cantidad'); // Cantidad de producto en el envío
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_envio')->references('id')->on('shipments')->onDelete('cascade');
            $table->foreign('producto')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_details');
    }
};

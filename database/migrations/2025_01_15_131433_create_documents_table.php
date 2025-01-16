<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable(); // Hace que el campo 'url' sea opcional
            $table->string('file_type')->nullable(); // Tipo de archivo (pdf, jpg, etc.)
            $table->integer('file_size')->nullable(); // Permite valores nulos
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};

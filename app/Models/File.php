<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // Especificamos la tabla que este modelo debe usar (aunque Laravel lo deduce por defecto)
    protected $table = 'files';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'file_name',   // Nombre del archivo
        'file_url',    // URL del archivo
    ];

    // Los campos que deben ser ocultados cuando se convierten a un arreglo o JSON
    protected $hidden = [
        'created_at', 'updated_at', // Si no quieres que se muestren estos campos
    ];
}

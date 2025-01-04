<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tribunal extends Model
{
    use HasFactory;

    // Especifica la tabla asociada
    protected $table = 'tribunal';

    // Habilitar asignación masiva para estos campos
    protected $fillable = [
        'nombre_Tribunal',
        'jurisdiccion',
    ];
}

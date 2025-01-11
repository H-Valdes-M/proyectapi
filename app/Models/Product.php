<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_Equipo',
        'subequipo',
        'marca',
        'modelo',
        'unidades_disponible',
        'stock_critico',

    ];


    protected $casts = [
        'unidades_disponible' => 'integer',
        'stock_critico' => 'integer',
        'estado_producto' => 'integer',
    ];
}

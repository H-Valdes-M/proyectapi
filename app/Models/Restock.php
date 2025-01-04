<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restock extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'restock'; 


    protected $fillable = [
        'producto',
        'usuario',
        'fecha',
        'cant_unidades',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}

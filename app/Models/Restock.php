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
        'producto',       // ID del producto relacionado
        'usuario',        // ID del usuario relacionado
        'fecha',          // Fecha del reabastecimiento
        'cant_unidades',  // Cantidad de unidades reabastecidas
        'coment',         // Comentario adicional
        'doc',            // Ruta del archivo relacionado
        'accion',         //añade o retira productos
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

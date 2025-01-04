<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'usuario',
        'tribunal',
        'fecha',
        'destinatario',
        'observacion',
        'guiadeMov',
        'nguiaMov',
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario');
    }

    // Relación con Tribunal
    public function tribunal()
    {
        return $this->belongsTo(Tribunal::class, 'tribunal');
    }
}

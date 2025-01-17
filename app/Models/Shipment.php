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
        'doc',
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario', 'id');
    }
    // Relación con Tribunal
    public function tribunal()
    {
        return $this->belongsTo(Tribunal::class, 'tribunal');
    }
    public function document()
    {
        return $this->belongsTo(Document::class, 'doc', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    use HasFactory;

    protected $table = 'shipment_details'; // Nombre de la tabla

    protected $fillable = [
        'id_envio',
        'producto',
        'cantidad',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'id_envio');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'producto');
    }
}

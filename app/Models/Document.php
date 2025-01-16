<?php

// app/Models/Document.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    
    // Definir los campos que pueden ser llenados masivamente (mass assignable)
    protected $fillable = [
        'url',
        'file_type',
        'file_size',
    ];


}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'codigo_embed'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCloudinaryFiles;

class Producto extends Model
{
    use HasFactory, HasCloudinaryFiles;

    protected $fillable = [
        'nombre', 'codigo', 'descripcion', 'precio', 'stock', 'imagen', 
        'destacado', 'categoria_id', 'marca_id', 'ficha_tecnica',
        'precio_compra', 'precio_docena', 'stock_min', 'estado', 'especificaciones'
    ];
    public function getCloudinaryFields(): array
    {
        return ['imagen', 'ficha_tecnica'];
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
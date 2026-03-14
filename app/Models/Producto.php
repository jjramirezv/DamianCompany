<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'descripcion', 'precio', 'stock', 'imagen', 'destacado', 'categoria_id', 'marca_id', 'ficha_tecnica'];

    //un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    //un producto pertenece a una marca
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}

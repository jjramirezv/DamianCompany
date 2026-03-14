<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    //campos que se pueden guardar
    protected $fillable = ['nombre', 'parent_id'];

    //una categoría padre tiene muchas subcategorías
    public function subCategorias()
    {
        return $this->hasMany(Categoria::class, 'parent_id');
    }

    //una subcategoría pertenece a una categoría padre
    public function parent()
    {
        return $this->belongsTo(Categoria::class, 'parent_id');
    }

    //una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}

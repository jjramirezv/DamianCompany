<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCloudinaryFiles;

class Marca extends Model
{
    use HasFactory, HasCloudinaryFiles;

    protected $fillable = ['nombre', 'logo'];

    public function getCloudinaryFields(): array
    {
        return ['logo'];
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
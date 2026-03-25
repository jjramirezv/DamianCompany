<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCloudinaryFiles;

class Proyecto extends Model
{
    use HasCloudinaryFiles;

    protected $fillable = ['titulo', 'descripcion', 'imagen', 'codigo_embed'];

    public function getCloudinaryFields(): array
    {
        return ['imagen'];
    }
}
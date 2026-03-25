<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCloudinaryFiles;

class Cliente extends Model
{
    use HasCloudinaryFiles;

    protected $fillable = [
        'nombre', 
        'logo'
    ];

    public function getCloudinaryFields(): array
    {
        return ['logo'];
    }
}
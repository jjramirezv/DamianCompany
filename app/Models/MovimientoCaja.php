<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table = 'movimientos_caja'; // Forzamos el nombre exacto de la tabla
    protected $fillable = ['tipo', 'monto', 'concepto', 'comprobante', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
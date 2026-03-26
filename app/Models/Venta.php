<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['cliente_nombre', 'cliente_id', 'total', 'metodo_pago', 'estado', 'user_id'];

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
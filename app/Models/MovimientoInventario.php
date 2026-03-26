<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario'; // Forzamos el nombre exacto de la tabla
    protected $fillable = [
        'producto_id', 'tipo', 'cantidad', 'motivo', 'user_id', 
        'stock_antes', 'stock_despues'
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
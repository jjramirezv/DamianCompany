<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;

class ProductosDestacados extends Component
{
    public function render()
    {
    //productos destacados (máx 8)
    $productos = Producto::where('destacado', true)
                        ->with(['categoria', 'marca'])
                        ->latest()
                        ->take(8)
                        ->get();    
    return view('livewire.productos-destacados',[
        'productos' => $productos
    ]);
    }
}

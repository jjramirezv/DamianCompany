<?php

namespace App\Filament\Resources\ProductoResource\Pages;

use App\Filament\Resources\ProductoResource;
use App\Models\MovimientoInventario;
use Filament\Resources\Pages\CreateRecord;

class CreateProducto extends CreateRecord
{
    protected static string $resource = ProductoResource::class;
    protected function afterCreate(): void
    {
        $producto = $this->record;
        if ($producto->stock > 0) {
            MovimientoInventario::create([
                'producto_id' => $producto->id,
                'tipo' => 'ingreso',
                'cantidad' => $producto->stock,
                'motivo' => 'Inventario Inicial',
                'user_id' => auth()->id(), 
            ]);
        }
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
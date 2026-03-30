<?php

namespace App\Filament\Resources\MovimientoInventarioResource\Pages;

use App\Filament\Resources\MovimientoInventarioResource;
use App\Models\Producto;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMovimientoInventario extends CreateRecord
{
    protected static string $resource = MovimientoInventarioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $productoId = $data['producto_id'];
        $cantidadMovimiento = $data['cantidad'];
        $tipoMovimiento = $data['tipo'];

        $producto = Producto::findOrFail($productoId);

        if ($tipoMovimiento === 'ingreso') {
            $producto->stock += $cantidadMovimiento;
        } elseif ($tipoMovimiento === 'salida') {
            if ($producto->stock < $cantidadMovimiento) {
                Notification::make()
                    ->title('Error de Stock')
                    ->body("No puedes registrar una salida de {$cantidadMovimiento} unidades. El producto '{$producto->nombre}' solo tiene {$producto->stock} unidades disponibles.")
                    ->danger()
                    ->send();

                $this->halt(); 
            }

            $producto->stock -= $cantidadMovimiento;
        }

        $producto->save();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
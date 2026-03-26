<?php

namespace App\Filament\Resources\MovimientoInventarioResource\Pages;

use App\Filament\Resources\MovimientoInventarioResource;
use App\Models\Producto;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMovimientoInventario extends CreateRecord
{
    protected static string $resource = MovimientoInventarioResource::class;

    // Esta función de Filament nos permite interceptar los datos JUSTO ANTES de guardarlos
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $productoId = $data['producto_id'];
        $cantidadMovimiento = $data['cantidad'];
        $tipoMovimiento = $data['tipo'];

        // Buscamos el producto en la base de datos
        $producto = Producto::findOrFail($productoId);

        // --- LÓGICA DE ACTUALIZACIÓN DEL STOCK ---

        if ($tipoMovimiento === 'ingreso') {
            // Si es ingreso, SUMAMOS al stock actual
            $producto->stock += $cantidadMovimiento;
        } elseif ($tipoMovimiento === 'salida') {
            // Si es salida, primero verificamos si hay stock suficiente
            if ($producto->stock < $cantidadMovimiento) {
                // Si no hay suficiente, lanzamos una notificación de error en rojo y detenemos todo
                Notification::make()
                    ->title('Error de Stock')
                    ->body("No puedes registrar una salida de {$cantidadMovimiento} unidades. El producto '{$producto->nombre}' solo tiene {$producto->stock} unidades disponibles.")
                    ->danger()
                    ->send();

                // Detenemos el proceso de creación de Filament lanzando una excepción vacía
                $this->halt(); 
            }

            // Si hay stock suficiente, RESTAMOS
            $producto->stock -= $cantidadMovimiento;
        }

        // Guardamos el producto con su nuevo stock actualizado
        $producto->save();

        // Retornamos los datos originales del formulario para que Filament termine de guardar el historial
        return $data;
    }

    // Opcional: Redirigir a la lista de movimientos después de guardar, no al detalle.
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
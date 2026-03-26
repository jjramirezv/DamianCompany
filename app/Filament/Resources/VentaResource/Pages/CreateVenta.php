<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\MovimientoCaja;
use App\Models\MovimientoInventario;
use App\Models\Producto;

class CreateVenta extends CreateRecord
{
    protected static string $resource = VentaResource::class;

    // Esta función se ejecuta JUSTO DESPUÉS de guardar la venta y sus detalles en la BD
    protected function afterCreate(): void
    {
        $venta = $this->record;

        // 1. REGISTRAMOS EL DINERO EN LA CAJA AUTOMÁTICAMENTE
        MovimientoCaja::create([
            'tipo' => 'ingreso',
            'monto' => $venta->total,
            'concepto' => 'Venta #' . $venta->id . ' (' . $venta->metodo_pago . ')',
            'user_id' => auth()->id(),
        ]);

        // 2. DESCONTAMOS EL STOCK Y GUARDAMOS EN EL KARDEX
        // Recorremos todos los productos que se agregaron en esa venta
        foreach ($venta->detalles as $detalle) {
            $producto = $detalle->producto;
            
            // Guardamos cómo estaba el stock antes de la venta
            $stock_antes = $producto->stock;
            // Calculamos cómo queda
            $stock_despues = $stock_antes - $detalle->cantidad;

            // Creamos la historia en el Kardex usando los campos de tu diagrama
            MovimientoInventario::create([
                'producto_id' => $producto->id,
                'tipo' => 'salida',
                'cantidad' => $detalle->cantidad,
                'motivo' => 'Venta #' . $venta->id,
                'stock_antes' => $stock_antes,
                'stock_despues' => $stock_despues,
                'user_id' => auth()->id(),
            ]);

            // Finalmente, le actualizamos el stock real al producto
            $producto->update([
                'stock' => $stock_despues
            ]);
        }
    }

    // Al terminar de vender, nos regresa a la lista de ventas
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
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

    protected function afterCreate(): void
    {
        $venta = $this->record;

        MovimientoCaja::create([
            'tipo' => 'ingreso',
            'monto' => $venta->total,
            'concepto' => 'Venta #' . $venta->id . ' (' . $venta->metodo_pago . ')',
            'user_id' => auth()->id(),
        ]);

        foreach ($venta->detalles as $detalle) {
            $producto = $detalle->producto;
            $stock_antes = $producto->stock;
            $stock_despues = $stock_antes - $detalle->cantidad;

            MovimientoInventario::create([
                'producto_id' => $producto->id,
                'tipo' => 'salida',
                'cantidad' => $detalle->cantidad,
                'motivo' => 'Venta #' . $venta->id,
                'stock_antes' => $stock_antes,
                'stock_despues' => $stock_despues,
                'user_id' => auth()->id(),
            ]);

            $producto->update([
                'stock' => $stock_despues
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
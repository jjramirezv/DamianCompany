<?php

namespace App\Filament\Resources\MovimientoInventarioResource\Pages;

use App\Filament\Resources\MovimientoInventarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovimientoInventarios extends ListRecords
{
    protected static string $resource = MovimientoInventarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getSubheading(): ?string
{
    return 'El Kardex es el historial detallado de tu almacén. Aquí verás cada entrada (compras/ajustes) y salida (ventas) de productos. Es la prueba de por qué el stock sube o baja.';
}
}

<?php

namespace App\Filament\Resources\MovimientoCajaResource\Pages;

use App\Filament\Resources\MovimientoCajaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovimientoCajas extends ListRecords
{
    protected static string $resource = MovimientoCajaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getSubheading(): ?string
{
    return 'Aquí se controla el dinero real de la empresa. "Ingreso" es dinero que entra (usualmente por ventas) y "Egreso" es dinero que sale (pagos, gastos, sueldos). El saldo final debe coincidir con tu caja física.';
}
}

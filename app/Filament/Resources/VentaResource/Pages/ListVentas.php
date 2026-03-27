<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use App\Exports\ReporteDiarioExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVentas extends ListRecords
{
    protected static string $resource = VentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nueva Venta'),
            
            Actions\Action::make('exportarExcel')
                ->label('Descargar Cierre del Día')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(fn () => Excel::download(new ReporteDiarioExport, 'Cierre_Damian_Company_' . now()->format('d_m_Y') . '.xlsx')),
        ];
    }
    public function getSubheading(): ?string
{
    return 'Módulo principal de ingresos. Al registrar una venta, el sistema hace tres cosas: genera el comprobante, descuenta el stock del Kardex y suma el dinero al Flujo de Caja automáticamente.';
}
}
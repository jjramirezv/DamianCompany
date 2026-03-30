<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Venta;
use App\Models\MovimientoCaja;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EstadisticasDashboard extends BaseWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        return [
            Stat::make('Ventas del Mes', 'S/ ' . number_format(Venta::whereMonth('created_at', now()->month)->sum('total'), 2))
                ->description('Ingresos acumulados')
                ->descriptionIcon('heroicon-m-presentation-chart-line')
                ->color('success'),

            Stat::make('Saldo en Caja', 'S/ ' . number_format(
                MovimientoCaja::where('tipo', 'ingreso')->sum('monto') - 
                MovimientoCaja::where('tipo', 'egreso')->sum('monto'), 2))
                ->description('Dinero disponible')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Reposición Urgente', Producto::whereColumn('stock', '<=', 'stock_min')->count())
                ->description('Productos por agotarse')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make('Total Productos', Producto::count())
                ->description('Equipos en sistema')
                ->descriptionIcon('heroicon-m-cube')
                ->color('gray'),

            Stat::make('Categorías', Categoria::count())
                ->description('Divisiones de catálogo')
                ->descriptionIcon('heroicon-m-tag')
                ->color('gray'),

            Stat::make('Marcas Partners', Marca::count())
                ->description('Marcas registradas')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('gray'),
        ];
    }
}
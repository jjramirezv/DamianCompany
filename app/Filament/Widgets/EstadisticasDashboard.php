<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use App\Models\Proyecto;
use App\Models\Servicio;
use App\Models\Cliente;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EstadisticasDashboard extends BaseWidget
{
    // Opcional: Esto hace que el widget ocupe todo el ancho disponible
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Productos', Producto::count())
                ->description('En el inventario')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success'), // Color verde

            Stat::make('Proyectos', Proyecto::count())
                ->description('Portafolio activo')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('info'), // Color azul claro

            Stat::make('Servicios', Servicio::count())
                ->description('Servicios ofrecidos')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning'), // Color naranja/amarillo

            Stat::make('Clientes', Cliente::count())
                ->description('Cartera de clientes')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'), // Color principal del panel
        ];
    }
}
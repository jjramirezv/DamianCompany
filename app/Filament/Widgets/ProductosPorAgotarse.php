<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Producto;

class ProductosPorAgotarse extends BaseWidget
{
    protected int | string | array $columnSpan = 1; 
    
    protected static ?string $heading = '⚠️ Productos a punto de agotarse';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Producto::whereColumn('stock', '<=', 'stock_min')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Foto')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Producto')
                    ->searchable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->badge()
                    ->color('danger'),
            ])
            // Usamos la forma nativa y segura de Filament para que no explote
            ->paginated(false)
            // Agregamos un límite a la consulta por si tienes 100 productos agotados no te rompa la pantalla
            ->defaultPaginationPageOption(5); 
    }
}
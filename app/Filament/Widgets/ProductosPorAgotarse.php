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
            ->paginated(false)
            ->defaultPaginationPageOption(5); 
    }
}
<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimosProductos extends BaseWidget
{
    protected int | string | array $columnSpan = 1;
    
    protected static ?string $heading = 'Últimos Productos Agregados';
    
    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Producto::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Foto')
                    ->circular(), 
                    
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Producto')
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('codigo')
                    ->label('SKU')
                    ->badge() 
                    ->color('info'),
                    
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoría'),
                    
                Tables\Columns\TextColumn::make('precio')
                    ->money('PEN')
                    ->label('Precio'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Agregado el')
                    ->dateTime('d/m/Y')
                    ->color('gray'),
            ])
            ->paginated(false); 
    }
}
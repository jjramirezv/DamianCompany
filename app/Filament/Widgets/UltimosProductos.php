<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimosProductos extends BaseWidget
{
    // Esto asegura que la tabla ocupe todo el ancho debajo de las tarjetas
    protected int | string | array $columnSpan = 'full';
    
    // El título que aparecerá arriba de la tabla
    protected static ?string $heading = 'Últimos Productos Agregados';
    
    // Le damos el orden 2 para que aparezca debajo de las estadísticas
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Traemos solo los últimos 5 productos creados
                Producto::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Foto')
                    ->circular(), // Para que la fotito se vea redonda
                    
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Producto')
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('codigo')
                    ->label('SKU')
                    ->badge() // Se verá como una pequeña etiqueta resaltada
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
            // Quitamos la paginación inferior porque solo queremos mostrar los últimos 5
            ->paginated(false); 
    }
}
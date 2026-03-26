<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimientoInventarioResource\Pages;
use App\Models\MovimientoInventario;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MovimientoInventarioResource extends Resource
{
    protected static ?string $model = MovimientoInventario::class;

    // Cambiamos el nombre que se muestra en el menú
    protected static ?string $navigationLabel = 'Kardex (Historial)';
    // Icono de flechas de intercambio
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left'; 

    protected static ?string $navigationGroup = 'Inventario';
    // Lo ponemos al final del grupo
    protected static ?int $navigationSort = 4; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registrar Nuevo Movimiento')
                    ->description('Selecciona el producto, el tipo de movimiento y la cantidad exacta.')
                    ->schema([
                        Forms\Components\Select::make('producto_id')
                            ->relationship('producto', 'nombre')
                            ->label('Producto')
                            ->searchable()
                            ->preload()
                            ->required()
                            // Activamos el modo live para poder reaccionar a cambios
                            ->live() 
                            // Pequeño truco para mostrar el stock actual debajo del selector
                            ->helperText(function (Forms\Get $get) {
                                $productoId = $get('producto_id');
                                if ($productoId) {
                                    $stockActual = Producto::find($productoId)?->stock ?? 0;
                                    return "Stock actual disponible: {$stockActual} unidades.";
                                }
                                return 'Selecciona un producto para ver su stock actual.';
                            }),

                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de Movimiento')
                            ->options([
                                'ingreso' => 'Suma (+)',
                                'salida' => 'Resta (-)',
                            ])
                            ->required()
                            // Cambia de color según la selección (Verde=Suma, Rojo=Resta)
                            ->native(false)
                            ->selectablePlaceholder(false),

                        Forms\Components\TextInput::make('cantidad')
                            ->label('Cantidad Exacta')
                            ->numeric()
                            ->required()
                            ->minValue(1) // No permitimos mover 0 o números negativos
                            ->default(1),

                        Forms\Components\TextInput::make('motivo')
                            ->label('Motivo / Referencia')
                            ->placeholder('Ej: Compra a proveedor X, Producto dañado en almacén...')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        // Ocultamos el campo user_id y le ponemos el ID del admin logueado por defecto
                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->id()),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Fecha formateada (día/mes/año hora:minuto)
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('producto.nombre')
                    ->label('Producto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                // SKU del producto (pequeño y en gris)
                Tables\Columns\TextColumn::make('producto.codigo')
                    ->label('SKU')
                    ->size('xs')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    // Lo convertimos en una etiqueta (badge) con colores
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ingreso' => 'success', // Verde
                        'salida' => 'danger',   // Rojo
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ingreso' => 'ENTRADA',
                        'salida' => 'SALIDA',
                    }),

                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('motivo')
                    ->label('Motivo / Referencia')
                    ->searchable()
                    ->limit(40), // Limitamos el texto para que no rompa la tabla

                // Mostramos qué admin hizo el registro
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Registrado por')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // Ordenamos por defecto del más nuevo al más viejo
            ->defaultSort('created_at', 'desc') 
            ->filters([
                // Filtro rápido por tipo de movimiento
                Tables\Filters\SelectFilter::make('tipo')
                    ->options([
                        'ingreso' => 'Entradas',
                        'salida' => 'Salidas',
                    ]),
            ])
            ->actions([
                // En un Kardex histórico, NO se deben permitir editar ni borrar registros
                // ya que rompería la trazabilidad. Solo permitimos ver detalles.
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No permitimos acciones masivas tampoco por seguridad del historial
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            // Solo creamos las páginas de listar y crear. Quitamos la de editar.
            'index' => Pages\ListMovimientoInventarios::route('/'),
            'create' => Pages\CreateMovimientoInventario::route('/create'),
        ];
    }
}
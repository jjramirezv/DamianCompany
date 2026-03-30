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

    protected static ?string $navigationLabel = 'Kardex (Historial)';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left'; 

    protected static ?string $navigationGroup = 'Inventario';
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
                            ->live() 
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
                                'ingreso' => 'Ingreso',
                                'salida' => 'Egreso',
                            ])
                            ->required()
                            ->native(false)
                            ->selectablePlaceholder(false),

                        Forms\Components\TextInput::make('cantidad')
                            ->label('Cantidad Exacta')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->default(1),

                        Forms\Components\TextInput::make('motivo')
                            ->label('Motivo / Referencia')
                            ->placeholder('Ej: Compra a proveedor X, Producto dañado en almacén...')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->id()),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('producto.nombre')
                    ->label('Producto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('producto.codigo')
                    ->label('SKU')
                    ->size('xs')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
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
                    ->limit(40), 
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Registrado por')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
           
            ->defaultSort('created_at', 'desc') 
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->options([
                        'ingreso' => 'Entradas',
                        'salida' => 'Salidas',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // 
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
            'index' => Pages\ListMovimientoInventarios::route('/'),
            'create' => Pages\CreateMovimientoInventario::route('/create'),
        ];
    }
}
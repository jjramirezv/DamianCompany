<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Models\Venta;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Punto de Venta';
    protected static ?string $navigationGroup = 'Gestión de Ventas';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // BLOQUE 1: DATOS DEL CLIENTE
                Forms\Components\Section::make('Datos de la Venta')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\Select::make('cliente_id')
                            ->relationship('cliente', 'nombre')
                            ->label('Cliente Registrado (Opcional)')
                            ->searchable()
                            ->preload()
                            ->helperText('Déjalo en blanco si es venta al Público General.'),

                        Forms\Components\TextInput::make('cliente_nombre')
                            ->label('Nombre (Público General)')
                            ->placeholder('Ej: Juan Pérez')
                            ->maxLength(255),

                        Forms\Components\Select::make('metodo_pago')
                            ->label('Método de Pago')
                            ->options([
                                'Efectivo' => 'Efectivo',
                                'Yape' => 'Yape',
                                'Plin' => 'Plin',
                                'Transferencia' => 'Transferencia',
                                'Tarjeta' => 'Tarjeta',
                            ])
                            ->required()
                            ->default('Efectivo'),
                            
                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->id()),
                    ])->columns(3),

                // BLOQUE 2: CARRITO DE COMPRAS (Repeater)
                Forms\Components\Section::make('Productos a Vender')
                    ->icon('heroicon-o-cube')
                    ->schema([
                        Forms\Components\Repeater::make('detalles')
                            ->relationship() // Guarda en la tabla venta_detalles
                            ->schema([
                                Forms\Components\Select::make('producto_id')
                                    ->relationship('producto', 'nombre')
                                    ->label('Producto')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disableOptionWhen(fn ($value) => Producto::find($value)?->stock <= 0) // Bloquea productos sin stock
                                    ->live() // Hace que reaccione al instante
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        // Cuando elige producto, jalamos su precio automáticamente
                                        $producto = Producto::find($state);
                                        if ($producto) {
                                            $set('precio_unitario', $producto->precio);
                                            $set('subtotal', $producto->precio * ($get('cantidad') ?: 1));
                                        }
                                    })
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('cantidad')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        // Si cambia la cantidad, recalculamos el subtotal
                                        $precio = $get('precio_unitario') ?: 0;
                                        $set('subtotal', $state * $precio);
                                    })
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('precio_unitario')
                                    ->label('Precio Unit.')
                                    ->numeric()
                                    ->readOnly() // No lo pueden editar a mano para evitar fraudes
                                    ->prefix('S/')
                                    ->columnSpan(3),

                                Forms\Components\TextInput::make('subtotal')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('S/')
                                    ->columnSpan(3),
                            ])
                            ->columns(12)
                            // Cuando se agrega o quita un producto del repeater, recalculamos el TOTAL FINAL
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                $total = collect($get('detalles'))->sum('subtotal');
                                $set('total', $total);
                            }),
                    ]),

                // BLOQUE 3: TOTAL
                Forms\Components\Section::make('Resumen')
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->label('TOTAL A COBRAR')
                            ->numeric()
                            ->readOnly() // Se llena solo
                            ->required()
                            ->prefix('S/')
                            ->extraInputAttributes(['class' => 'text-3xl font-black text-primary-600']),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('N° Venta')
                    ->sortable()
                    ->prefix('#000'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente Registrado')
                    ->default(fn ($record) => $record->cliente_nombre ?: 'Público General'),

                Tables\Columns\TextColumn::make('metodo_pago')
                    ->label('Pago')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('total')
                    ->money('PEN')
                    ->weight('bold')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->size('xs')
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            // Igual que en el Kardex, las ventas no se "editan" una vez hechas.
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
        ];
    }
}
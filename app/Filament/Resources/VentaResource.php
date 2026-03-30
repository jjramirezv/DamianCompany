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

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

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
                // BLOQUE 1: datos del cliente y comprobante
                Forms\Components\Section::make('Datos del Cliente y Comprobante')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Forms\Components\Select::make('tipo_documento')
                            ->label('Tipo de Comprobante')
                            ->options([
                                'Ninguno' => 'Nota de Venta (Público General)',
                                'DNI' => 'Boleta (DNI)',
                                'RUC' => 'Factura (RUC)',
                            ])
                            ->default('Ninguno')
                            ->live() 
                            ->afterStateUpdated(function (Set $set) {
                                $set('numero_documento', null);
                                $set('cliente_nombre', null);
                            }),

                        Forms\Components\TextInput::make('numero_documento')
                            ->label('Número de Documento')
                            ->numeric()
                            ->hidden(fn (Get $get) => $get('tipo_documento') === 'Ninguno')
                            ->required(fn (Get $get) => $get('tipo_documento') !== 'Ninguno')
                            ->suffixAction(
                                Action::make('buscarDoc')
                                    ->icon('heroicon-m-magnifying-glass')
                                    ->action(function (Set $set, $state, Get $get) {
                                        if (blank($state)) return;
                                        
                                        $tipo = $get('tipo_documento');
                                        $token = env('APIPERU_TOKEN'); 
                                        
                                        $url = $tipo === 'DNI' 
                                            ? "https://apiperu.dev/api/dni/{$state}" 
                                            : "https://apiperu.dev/api/ruc/{$state}";

                                        $response = Http::withoutVerifying()->withToken($token)->get($url);

                                        if ($response->successful() && $response->json('success')) {
                                            $datos = $response->json('data');
                                            $nombre = $tipo === 'DNI' ? $datos['nombre_completo'] : $datos['nombre_o_razon_social'];
                                            
                                            $set('cliente_nombre', $nombre);
                                            Notification::make()->title('Datos encontrados')->success()->send();
                                        } else {
                                            $set('cliente_nombre', null);
                                            Notification::make()->title('Documento no encontrado')->danger()->send();
                                        }
                                    })
                            ),

                        Forms\Components\TextInput::make('cliente_nombre')
                            ->label('Nombre o Razón Social')
                            ->required()
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
                    ])->columns(2),

                // BLOQUE 2: productos a vender
                Forms\Components\Section::make('Productos a Vender')
                    ->icon('heroicon-o-cube')
                    ->schema([
                        Forms\Components\Repeater::make('detalles')
                            ->relationship() 
                            ->schema([
                                Forms\Components\Select::make('producto_id')
                                    ->relationship('producto', 'nombre')
                                    ->label('Producto')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disableOptionWhen(fn ($value) => Producto::find($value)?->stock <= 0) 
                                    ->live() 
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        // 1. Calculamos los datos de esta fila
                                        $producto = Producto::find($state);
                                        if ($producto) {
                                            $precio = $producto->precio;
                                            $cantidad = floatval($get('cantidad') ?: 1);
                                            $set('precio_unitario', $precio);
                                            $set('subtotal', $precio * $cantidad);
                                        }
                                        
                                        $total = collect($get('../../detalles'))->sum('subtotal');
                                        $set('../../total', $total);
                                    })
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('cantidad')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live(onBlur: true) 
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $precio = floatval($get('precio_unitario') ?: 0);
                                        $set('subtotal', floatval($state ?: 1) * $precio);
                                        
                                        $total = collect($get('../../detalles'))->sum('subtotal');
                                        $set('../../total', $total);
                                    })
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('precio_unitario')
                                    ->label('Precio Unit.')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('S/')
                                    ->columnSpan(3),

                                Forms\Components\TextInput::make('subtotal')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('S/')
                                    ->columnSpan(3),
                            ])
                            ->columns(12)
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                $set('total', collect($get('detalles'))->sum('subtotal'));
                            })
                            ->deleteAction(
                                fn (Forms\Components\Actions\Action $action) => $action->after(function(Forms\Get $get, Forms\Set $set) {
                                    $set('total', collect($get('detalles'))->sum('subtotal'));
                                })
                            ),
                    ]),

                // BLOQUE 3: resumen
                Forms\Components\Section::make('Resumen')
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->label('TOTAL A COBRAR')
                            ->numeric()
                            ->readOnly()
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

                Tables\Columns\TextColumn::make('cliente_nombre')
                    ->label('Cliente')
                    ->default('Público General')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tipo_documento')
                    ->label('Comprobante')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Factura' => 'danger',
                        'Boleta' => 'success',
                        default => 'gray',
                    }),

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
                
                Tables\Actions\Action::make('pdf')
                    ->label('Imprimir Boleta')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function (Venta $record) {
                        ini_set('memory_limit', '512M'); 
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadView('pdf.comprobante', ['venta' => $record])->output();
                        }, 'Comprobante-' . str_pad($record->id, 8, '0', STR_PAD_LEFT) . '.pdf');
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
        ];
    }
}
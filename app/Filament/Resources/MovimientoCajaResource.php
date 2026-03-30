<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimientoCajaResource\Pages;
use App\Models\MovimientoCaja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MovimientoCajaResource extends Resource
{
    protected static ?string $model = MovimientoCaja::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Flujo de Caja';
    protected static ?string $navigationGroup = 'Gestión de Ventas';
    protected static ?int $navigationSort = 2; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registrar Movimiento de Dinero')
                    ->description('Añade un gasto del local o un ingreso manual.')
                    ->schema([
                        Forms\Components\Select::make('tipo')
                            ->options([
                                'ingreso' => 'Ingreso de Dinero (+)',
                                'egreso' => 'Gasto / Salida de Dinero (-)',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('monto')
                            ->numeric()
                            ->required()
                            ->prefix('S/'),

                        Forms\Components\TextInput::make('concepto')
                            ->placeholder('Ej: Pago de luz, Pago a proveedor de repuestos...')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('comprobante')
                            ->label('N° de Comprobante (Opcional)')
                            ->placeholder('Ej: Factura F001-234')
                            ->maxLength(255),

                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->id()),
                    ])->columns(2),
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

                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ingreso' => 'success',
                        'egreso' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state) => strtoupper($state)),

                Tables\Columns\TextColumn::make('concepto')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('monto')
                    ->money('PEN')
                    ->weight('bold')
                    ->color(fn ($record) => $record->tipo === 'ingreso' ? 'success' : 'danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('comprobante')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Registrado por')
                    ->size('xs')
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->options([
                        'ingreso' => 'Solo Ingresos',
                        'egreso' => 'Solo Egresos',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovimientoCajas::route('/'),
            'create' => Pages\CreateMovimientoCaja::route('/create'),
            'edit' => Pages\EditMovimientoCaja::route('/{record}/edit'),
        ];
    }
}
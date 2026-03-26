<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use App\Models\Categoria; 
use App\Models\Marca;    
use Illuminate\Support\Str; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Inventario';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // BLOQUE 1: DATOS PRINCIPALES
                Forms\Components\Section::make('Información Principal')
                    ->description('Datos básicos y clasificación del producto.')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('categoria_id')
                            ->relationship('categoria', 'nombre')
                            ->label('Categoría')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::generarSKU($set, $get)),

                        Forms\Components\Select::make('marca_id')
                            ->relationship('marca', 'nombre')
                            ->label('Marca')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::generarSKU($set, $get)),

                        Forms\Components\TextInput::make('codigo')
                            ->label('Código (SKU)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Se genera solo, pero puedes editarlo.'),
                    ])->columns(3),

                // BLOQUE 2: PRECIOS (El área de dinero)
                Forms\Components\Section::make('Costos y Precios')
                    ->description('Define cuánto te costó y a cuánto lo vendes.')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Forms\Components\TextInput::make('precio_compra')
                            ->label('Precio de Compra (Costo)')
                            ->numeric()
                            ->prefix('S/'),

                        Forms\Components\TextInput::make('precio')
                            ->label('Precio Venta Público')
                            ->numeric()
                            ->required()
                            ->prefix('S/'),

                        Forms\Components\TextInput::make('precio_docena')
                            ->label('Precio por Docena (Por Mayor)')
                            ->numeric()
                            ->prefix('S/'),
                    ])->columns(3),

                // BLOQUE 3: INVENTARIO Y ALERTAS
                Forms\Components\Section::make('Control de Inventario')
                    ->description('Configura el stock y las alertas de escasez.')
                    ->icon('heroicon-o-archive-box')
                    ->schema([
                        Forms\Components\TextInput::make('stock')
                            ->label('Stock Actual')
                            ->numeric()
                            ->default(0)
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->helperText(fn (string $operation): string => 
                                $operation === 'edit' 
                                    ? 'Usa el Kardex para modificar el stock.' 
                                    : 'Stock al registrar el producto por primera vez.'
                            ),

                        Forms\Components\TextInput::make('stock_min')
                            ->label('Alerta de Stock Mínimo')
                            ->numeric()
                            ->default(5)
                            ->helperText('Te avisaremos cuando queden menos de esta cantidad.'),
                    ])->columns(2),

                // BLOQUE 4: DETALLES EXTRAS Y VISIBILIDAD
                Forms\Components\Section::make('Detalles y Visibilidad')
                    ->icon('heroicon-o-eye')
                    ->collapsed() // Esto hace que empiece cerrado para no abrumar al usuario
                    ->schema([
                        Forms\Components\Toggle::make('estado')
                            ->label('Producto Activo (Visible para vender)')
                            ->default(true),

                        Forms\Components\Toggle::make('destacado')
                            ->label('Mostrar en Destacados de la web')
                            ->default(false),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción Breve')
                            ->rows(3),

                        Forms\Components\Textarea::make('especificaciones')
                            ->label('Especificaciones Técnicas Completas')
                            ->rows(4),

                        Forms\Components\TextInput::make('ficha_tecnica')
                            ->label('Link del Manual / Ficha PDF')
                            ->url(),

                        Forms\Components\FileUpload::make('imagen')
                            ->image()
                            ->disk('cloudinary')
                            ->directory('productos')
                            ->label('Foto principal')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
    public static function generarSKU(Forms\Set $set, Forms\Get $get)
    {
        $categoriaId = $get('categoria_id');
        $marcaId = $get('marca_id');

        if (!$categoriaId) {
            return; 
        }

        $categoria = Categoria::find($categoriaId);
        $marca = $marcaId ? Marca::find($marcaId) : null;

        $prefijoCat = $categoria ? Str::upper(Str::substr($categoria->nombre, 0, 3)) : 'GEN';
        $prefijoMar = $marca ? Str::upper(Str::substr($marca->nombre, 0, 3)) : 'GEN';
        
        $numero = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $set('codigo', "{$prefijoCat}-{$prefijoMar}-{$numero}");
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => "SKU: {$record->codigo}"),

                // PRECIOS A LA VISTA
                Tables\Columns\TextColumn::make('precio_compra')
                    ->label('Costo')
                    ->money('PEN')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('precio')
                    ->label('Venta')
                    ->money('PEN')
                    ->weight('bold')
                    ->color('success'),

                // STOCK CON SEMÁFORO DE COLORES
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock Actual')
                    ->weight('black')
                    ->alignCenter()
                    ->color(fn ($record) => match (true) {
                        $record->stock <= 0 => 'danger',         // Rojo si es 0
                        $record->stock <= $record->stock_min => 'warning', // Naranja si es bajo
                        default => 'success',                    // Verde si está bien
                    })
                    ->description(fn ($record) => "Mín: {$record->stock_min}"),

                Tables\Columns\ToggleColumn::make('estado')
                    ->label('¿Activo?'),
                    
                // INTERRUPTOR DE PORTADA (WELCOME)
                Tables\Columns\ToggleColumn::make('destacado')
                    ->label('¿En Portada?')
                    ->onColor('warning') // Un color distinto (ámbar/dorado) para diferenciarlo
                    ->offIcon('heroicon-m-star')
                    ->onIcon('heroicon-m-star'),
            ])
            
            ->filters([
                Tables\Filters\Filter::make('stock_bajo')
                    ->label('Solo Stock Bajo / Agotado')
                    ->query(fn (Builder $query) => $query->whereColumn('stock', '<=', 'stock_min'))
                    ->toggle() // Esto lo convierte en un interruptor visual muy fácil de usar
                    ->indicator('Viendo solo stock bajo'),
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
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
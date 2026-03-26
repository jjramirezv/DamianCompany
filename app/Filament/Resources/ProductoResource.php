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
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('categoria_id')
                    ->relationship('categoria', 'nombre')
                    ->label('Categoria')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                        self::generarSKU($set, $get);
                    }),

                Forms\Components\Select::make('marca_id')
                    ->relationship('marca', 'nombre')
                    ->label('Marca')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                        self::generarSKU($set, $get);
                    }),

                Forms\Components\TextInput::make('codigo')
                    ->label('Código de Venta (SKU)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Código autogenerado basado en Categoría y Marca (Ej. MOT-STI-4829). Puedes editarlo manualmente si lo deseas.'),

                Forms\Components\TextInput::make('precio')
                    ->numeric()
                    ->prefix('S/'),

                Forms\Components\TextInput::make('stock')
                    ->numeric()
                    ->default(0),

                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción y Ficha Técnica')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('imagen')
                    ->image()
                    ->disk('cloudinary') 
                    ->directory('productos')
                    ->label('Imagen del Producto') 
                    ->columnSpanFull(),   

                Forms\Components\Toggle::make('destacado')
                    ->label('¿Mostrar en Destacados del Inicio?')
                    ->default(false)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('ficha_tecnica')
                    ->label('Link de Ficha Técnica (Google Drive / Web oficial)')
                    ->url()
                    ->placeholder('Ej: https://drive.google.com/file/d/....')
                    ->maxLength(255)
                    ->columnSpanFull(),
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
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('codigo')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoria')
                    ->sortable(),
                Tables\Columns\TextColumn::make('marca.nombre')
                    ->label('Marca')
                    ->sortable(),
                Tables\Columns\TextColumn::make('precio')
                    ->money('PEN')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('destacado')    
                    ->label('Destacado'),              
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
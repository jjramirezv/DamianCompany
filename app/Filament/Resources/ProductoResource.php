<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('codigo')
                    ->label('Código de Venta (SKU)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('Ej. MS-382, BOM-123')
                    ->maxLength(255),

                // ¡AQUÍ ESTÁ LA CORRECCIÓN! (Antes decía 'codigo')
                Forms\Components\Select::make('categoria_id')
                    ->relationship('categoria', 'nombre')
                    ->label('Categoria')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('marca_id')
                    ->relationship('marca','nombre')
                    ->label('Marca')
                    ->searchable()
                    ->preload(),

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
                    ->maxLength(255),
                            ]);
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

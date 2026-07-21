<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyectoResource\Pages;
use App\Filament\Resources\ProyectoResource\RelationManagers;
use App\Models\Proyecto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProyectoResource extends Resource
{
    protected static ?string $model = Proyecto::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationGroup = 'Gestión de Proyectos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                    
                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción del proyecto')
                    ->required()
                    ->rows(10)
                    ->helperText('Puedes escribir una descripción extensa. En la web se mostrará resumida con la opción “Ver más”.')
                    ->columnSpanFull(),

                Forms\Components\Section::make('Galería multimedia')
                    ->description('Sube hasta 5 imágenes. La primera será la portada y puedes arrastrarlas para cambiar el orden.')
                    ->schema([
                        Forms\Components\FileUpload::make('imagenes')
                            ->label('Imágenes del proyecto')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->reorderable()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->imagePreviewHeight('180')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(10240)
                            ->directory('proyectos')
                            ->disk('cloudinary')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('video_url')
                            ->label('Enlace o código iframe de YouTube')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('https://www.youtube.com/watch?v=... o <iframe ...></iframe>')
                            ->helperText('Opcional. Puedes pegar el enlace de YouTube o el código iframe completo que entrega YouTube.')
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, \Closure $fail): void {
                                        if (!$value) {
                                            return;
                                        }

                                        $proyecto = new Proyecto(['video_url' => trim($value)]);

                                        if (!$proyecto->youtube_embed_url) {
                                            $fail('Ingresa un enlace o código iframe válido de YouTube.');
                                        }
                                    };
                                },
                            ])
                            ->dehydrateStateUsing(fn (?string $state): ?string => $state ? trim($state) : null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título del Proyecto')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('imagenes')
                    ->label('Galería')
                    ->formatStateUsing(fn (Proyecto $record): string => count($record->imagenes ?? ($record->imagen ? [$record->imagen] : [])) . ' imagen(es)')
                    ->badge()
                    ->color('info'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Publicado el')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProyectos::route('/'),
            'create' => Pages\CreateProyecto::route('/create'),
            'edit' => Pages\EditProyecto::route('/{record}/edit'),
        ];
    }
}

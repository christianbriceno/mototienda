<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PresentationExporter;
use App\Filament\Resources\PresentationResource\Pages;
use App\Filament\Resources\PresentationResource\RelationManagers;
use App\Models\Presentation;
use App\Policies\PresentationPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresentationResource extends Resource
{
    protected static ?string $model = Presentation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Presentación';

    protected static ?string $pluralModelLabel = 'Presentaciones';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Tienda - Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric(),
                // Forms\Components\FileUpload::make('photo')
                //     ->label('Foto')
                //     ->image()
                //     ->imageEditor()
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\ImageColumn::make('photo')
                //     ->label('Foto')
                //     ->rounded(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn(): bool => auth()->user()->can('delete Presentation', PresentationPolicy::class)),
                    ExportBulkAction::make()
                        ->exporter(PresentationExporter::class)
                        ->visible(fn(): bool => auth()->user()->can('create Presentation', PresentationPolicy::class))
                ]),
            ])->headerActions([
                ExportAction::make()
                    ->exporter(PresentationExporter::class)
                    ->visible(fn(): bool => auth()->user()->can('create Presentation', PresentationPolicy::class))
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
            'index' => Pages\ListPresentations::route('/'),
            'create' => Pages\CreatePresentation::route('/create'),
            'edit' => Pages\EditPresentation::route('/{record}/edit'),
        ];
    }
}

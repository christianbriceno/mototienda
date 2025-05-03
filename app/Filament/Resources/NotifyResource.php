<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotifyResource\Pages;
use App\Filament\Resources\NotifyResource\RelationManagers;
use App\Models\Notify;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotifyResource extends Resource
{
    protected static ?string $model = Notify::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Notificación';

    protected static ?string $pluralModelLabel = 'Notificaciones';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Tienda - Seguridad';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('notifiable_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('notifiable_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('read_at'),
                Forms\Components\Textarea::make('data')
                    ->autosize()
                    ->readOnly()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('notifiable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('notifiable_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('read_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListNotifies::route('/'),
            'create' => Pages\CreateNotify::route('/create'),
            'edit' => Pages\EditNotify::route('/{record}/edit'),
        ];
    }
}

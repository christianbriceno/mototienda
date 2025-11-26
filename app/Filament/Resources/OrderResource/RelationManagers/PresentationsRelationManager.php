<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Filament\Resources\PresentationResource;
use App\Models\Presentation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;

class PresentationsRelationManager extends RelationManager
{
    protected static string $relationship = 'presentations';

    public function form(Form $form): Form
    {
        return PresentationResource::form($form);
    }

    public function table(Table $table): Table
    {
        return PresentationResource::table($table)
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Presentación'),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad'),

                Tables\Columns\TextColumn::make('unit_price')->money('USD')
                    ->label('Precio unitario'),

                Tables\Columns\TextColumn::make('sub_total_unit_price')
                    ->label('Sub total precio unitario')
                    ->money('USD')
                    ->summarize(Sum::make()->label('Total precio unitario')->money('USD')),

                Tables\Columns\TextColumn::make('unit_price_without_iva')->money('USD')
                    ->label('Precio unitario sin iva'),

                Tables\Columns\TextColumn::make('sub_total_unit_price_without_iva')
                    ->label('Sub total precio unitario sin iva')
                    ->money('USD')
                    ->summarize(Sum::make()->label('Total precio unitario sin iva')->money('USD')),

                Tables\Columns\TextColumn::make('unit_cost')
                    ->label('Costo unitario')
                    ->money('USD'),

                Tables\Columns\TextColumn::make('sub_total_unit_cost')
                    ->label('Sub total costo unitario')
                    ->money('USD')
                    ->summarize(Sum::make()->label('Total costo unitario')->money('USD')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\AttachAction::make()
                //     ->preloadRecordSelect()
                //     ->form(fn (Tables\Actions\AttachAction $action): array => [
                //         $action->getRecordSelect()
                //             ->afterStateUpdated(function ($state, Set $set, Get $get) {
                //                 $set('unit_price', Presentation::find($state)?->price ?? 0);
                //                 $set('quantity', 1 ?? 0);
                //                 $set('sub_total', $get('quantity') * $get('unit_price') ?? 0);
                //             })
                //             ->distinct()
                //             ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                //             ->required(),
                //         Forms\Components\TextInput::make('quantity')
                //             ->live(debounce: 800)
                //             ->numeric()
                //             ->afterStateUpdated(function ($state, Set $set, Get $get) {
                //                 $set('sub_total', $state * $get('unit_price') ?? 0);
                //             })
                //             ->required(),
                //         Forms\Components\TextInput::make('unit_price')->required(),
                //         Forms\Components\TextInput::make('sub_total')->required(),
                //     ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\SexResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SexRelationManager extends RelationManager
{
    protected static string $relationship = 'sex';

    public function form(Form $form): Form
    {
        return SexResource::form($form);
    }

    public function table(Table $table): Table
    {
        return SexResource::table($table);
    }
}

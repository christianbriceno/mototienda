<?php

namespace App\Filament\Resources\SexResource\RelationManagers;

use App\Filament\Resources\ClientResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientsRelationManager extends RelationManager
{
    protected static string $relationship = 'clients';

    public function form(Form $form): Form
    {
        return ClientResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ClientResource::table($table);
    }
}

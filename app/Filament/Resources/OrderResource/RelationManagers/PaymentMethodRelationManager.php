<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Filament\Resources\PaymentMethodResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMethodRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentMethod';

    public function form(Form $form): Form
    {
        return PaymentMethodResource::form($form);
    }

    public function table(Table $table): Table
    {
        return PaymentMethodResource::table($table);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Factura';

    protected static ?string $pluralModelLabel = 'Facturas';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Tienda - Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Pertenece a')
                            ->schema(static::getBelongToFormField())->columns(3),

                        Forms\Components\Section::make('Datos del emisor')
                            ->schema(static::getDetailsIssuerFormField())->columns(2),

                        Forms\Components\Section::make('Datos del receptor')
                            ->schema(static::getDetailsReceiverFormField())->columns(2)
                    ])
                    ->columnSpan(['lg' => fn(?Invoice $record) => $record === null ? 3 : 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Datos del IVA')
                            ->schema(static::getDetailsIvaFormField())
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn(?Invoice $record) => $record === null),

                        Forms\Components\Section::make('Fecha y hora de emisión')
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Creado')
                                    ->content(fn(Invoice $record): ?string => $record->created_at?->diffForHumans()),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Última modificación')
                                    ->content(fn(Invoice $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn(?Invoice $record) => $record === null),
                    ])
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.id')
                    ->label('# Pedido')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id')
                    ->label('# Factura')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('buyer.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('issuer_rif')
                //     ->label('Rif emisor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('issuer_name')
                //     ->label('Nombre emisor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('issuer_address')
                //     ->label('Dirección emisor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('issuer_phone_number')
                //     ->label('Telefono emisor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('issuer_email')
                //     ->label('Correo emisor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receiver_rif')
                //     ->label('Rif receptor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receiver_identification_card')
                //     ->label('Cedula receptor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receiver_name')
                //     ->label('Nombre receptor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receiver_address')
                //     ->label('Dirección receptor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receiver_phone_number')
                //     ->label('Telefono receptor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receiver_email')
                //     ->label('Correo receptor')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('amount_iva')
                    ->label('Iva')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_without_iva')
                    ->label('Tatal sin iva')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_with_iva')
                    ->label('Total con iva')
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
                Action::make('invoice')
                    ->label('Factura')
                    ->url(function (Invoice $record) {
                        $invoice = Invoice::where('order_id', $record->order_id)->first();
                        return route('invoices.print', ['invoice' => $invoice]);
                    })->extraAttributes([
                        'target' => '_blank',
                    ])
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
            'index' => Pages\ListInvoices::route('/'),
            // 'create' => Pages\CreateInvoice::route('/create'),
            // 'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('order_id', 'desc');
    }

    public static function getBelongToFormField(): array
    {
        return [
            static::getStoreFormField(),
            static::getBuyerFormField(),
            static::getOrderFormField(),
        ];
    }

    public static function getDetailsIssuerFormField(): array
    {
        return [
            static::getRifIssuerFormField(),
            static::getNameIssuerFormField(),
            static::getAddressIssuerFormField(),
            static::getPhoneIssuerNumberFormField(),
            static::getEmailIssuerFormField(),
        ];
    }

    public static function getDetailsReceiverFormField(): array
    {
        return [
            static::getRifReceiverFormField(),
            static::getIdentificationCardReceiverFormField(),
            static::getNameReceiverFormField(),
            static::getAddressReceiverFormField(),
            static::getPhoneReceiverNumberFormField(),
            static::getEmailReceiverFormField(),
        ];
    }

    public static function getDetailsIvaFormField(): array
    {
        return [
            static::getAmountIvaFormField(),
            static::getTotalWithoutIvaFormField(),
            static::getTotalWithIvaFormField(),
        ];
    }

    public static function getStoreFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('store_id')
            ->label('Tienda')
            ->relationship('store', 'name')
            ->required();
    }

    public static function getBuyerFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('client_id')
            ->label('Comprador')
            ->relationship('buyer', 'name')
            ->required();
    }

    public static function getOrderFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('order_id')
            ->label('Pedido')
            ->relationship('order', 'id')
            ->required();
    }

    public static function getRifIssuerFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('issuer_rif')
            ->label('Rif emisor')
            ->required()
            ->maxLength(255);
    }

    public static function getNameIssuerFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('issuer_name')
            ->label('Nombre emisor')
            ->required()
            ->maxLength(255);
    }

    public static function getAddressIssuerFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('issuer_address')
            ->label('Dirección emisor')
            ->required()
            ->maxLength(255);
    }

    public static function getPhoneIssuerNumberFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('issuer_phone_number')
            ->label('Telefono emisor')
            ->tel()
            ->required()
            ->maxLength(255);
    }

    public static function getEmailIssuerFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('issuer_email')
            ->label('Correo emisor')
            ->email()
            ->required()
            ->maxLength(255);
    }

    public static function getRifReceiverFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('receiver_rif')
            ->label('Rif receptor')
            ->maxLength(255);
    }

    public static function getIdentificationCardReceiverFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('receiver_identification_card')
            ->label('Cedula receptor')
            ->maxLength(255);
    }

    public static function getNameReceiverFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('receiver_name')
            ->label('Nombre receptor')
            ->required()
            ->maxLength(255);
    }

    public static function getAddressReceiverFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('receiver_address')
            ->label('Dirección receptor')
            ->maxLength(255);
    }

    public static function getPhoneReceiverNumberFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('receiver_phone_number')
            ->label('Telefono receptor')
            ->tel()
            ->maxLength(255);
    }

    public static function getEmailReceiverFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('receiver_email')
            ->label('Correo receptor')
            ->email()
            ->maxLength(255);
    }

    public static function getAmountIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('amount_iva')
            ->label('Iva')
            ->numeric()
            ->default(0);
    }

    public static function getTotalWithIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_with_iva')
            ->label('Total con iva')
            ->numeric()
            ->default(0);
    }

    public static function getTotalWithoutIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_without_iva')
            ->label('Tatal sin iva')
            ->numeric()
            ->default(0);
    }
}

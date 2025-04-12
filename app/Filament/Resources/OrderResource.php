<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\BuyerRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\PresentationsRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\PaymentMethodRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\InvoiceRelationManager;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Presentation;
use App\Models\Role;
use App\Models\Invoice;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Pedido';

    protected static ?string $pluralModelLabel = 'Pedidos';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Tienda - Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Comprador')
                            ->schema(static::getDetailsFormSchema())
                            ->columns(2),

                        Forms\Components\Section::make('Presentaciones del pedido')
                            ->schema([
                                static::getItemsRepeater(),
                            ]),

                        Forms\Components\Section::make('Detalle de pago')
                            ->schema([
                                static::getCalculatePayFieldset(),
                            ]),
                    ])
                    ->columnSpan(['lg' => fn(?Order $record) => $record === null ? 3 : 3]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Creado')
                            ->content(fn(Order $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última modificación')
                            ->content(fn(Order $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Order $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('# Pedido')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('buyer.name')
                    ->label('Comprador')
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Método de pago')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección')
                    ->hidden()
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_price_usd')
                    ->label('Precio Total $')
                    ->money('USD')
                    ->summarize(Sum::make()->label('Precio Total $')->money('USD')),

                Tables\Columns\TextColumn::make('total_cost_usd')
                    ->label('Costo Total $')
                    // ->visible(function () {
                    //     return auth()->user()->roles->first()->level <= Role::LEVEL_ADMIN;
                    // })
                    ->money('USD')
                    ->summarize(
                        Sum::make()->label('Costo Total $')->money('USD'),
                    ),

                Tables\Columns\TextColumn::make('amount_iva')
                    ->label('IVA')
                    ->money('USD')
                    ->summarize(Sum::make()->label('Total IVA')->money('USD')),

                Tables\Columns\TextColumn::make('ganancia')
                    ->default(fn(Order $record) => ($record->total_price_usd - $record->total_cost_usd))
                    // ->visible(function () {
                    //     return auth()->user()->roles->first()->level <= Role::LEVEL_ADMIN;
                    // })
                    ->money('USD')
                    ->summarize(Summarizer::make()
                        ->label('Ganancia')
                        ->money('USD')
                        ->using(fn(Builder $query) => ($query->sum('total_price_usd') - $query->sum('total_cost_usd')))),

                // Tables\Columns\TextColumn::make('% de ganancia sobre el precio')
                //     ->default(function (Order $record) {
                //         $percentageAgain = ((($record->total_price_usd - $record->total_cost_usd) / ($record->total_price_usd)) * 100);
                //         return round($percentageAgain, 2);
                //     })
                //     ->visible(function () {
                //         return auth()->user()->roles->first()->level <= Role::LEVEL_ADMIN;
                //     })
                //     ->summarize(Summarizer::make()
                //         ->label('% de Ganancia Sobre El Precio')
                //         ->using(function (Builder $query) {
                //             $percentageAgain = ((($query->sum('total_price_usd') - $query->sum('total_cost_usd')) / ($query->sum('total_price_usd'))) * 100);
                //             return round($percentageAgain, 2);
                //         })),

                // Tables\Columns\TextColumn::make('% de ganancia sobre el costo')
                //     ->default(function (Order $record) {
                //         $percentageAgain = ((($record->total_cost_usd - $record->total_price_usd) / ($record->total_cost_usd)) * 100) * -1;
                //         return round($percentageAgain, 2);
                //     })
                //     ->visible(function () {
                //         return auth()->user()->roles->first()->level <= Role::LEVEL_ADMIN;
                //     })
                //     ->summarize(Summarizer::make()
                //         ->label('% de Ganancia Sobre El Costo')
                //         ->using(function (Builder $query) {
                //             $percentageAgain = ((($query->sum('total_cost_usd') - $query->sum('total_price_usd')) / $query->sum('total_cost_usd')) * 100) * -1;
                //             return round($percentageAgain, 2);
                //         })),

                // Tables\Columns\TextColumn::make('total_price_bs')
                //     ->label('Precio Total Bs')
                //     ->default(fn (Order $record) => $record->orderPresentations->sum('sub_total_unit_price'))
                //     ->money('USD')
                //     ->summarize(Sum::make()->label('Precio Total Bs')->money('USD')),

                // Tables\Columns\TextColumn::make('total_cost_bs')
                //     ->label('Costo Total Bs')
                //     ->default(fn (Order $record) => $record->orderPresentations->sum('sub_total_unit_cost'))
                //     ->money('USD')
                //     ->summarize(Sum::make()->label('Costo Total Bs')->money('USD')),

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
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('pedidos desde'),
                        DatePicker::make('pedidos hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['pedidos desde'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['pedidos hasta'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
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
            BuyerRelationManager::class,
            PresentationsRelationManager::class,
            PaymentMethodRelationManager::class,
            InvoiceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): EloquentBuilder
    {
        return parent::getEloquentQuery()->orderBy('id', 'desc');
    }

    public static function getDetailsFormSchema(): array
    {
        return [
            static::getBuyerFormField(),
            static::getPaymentMethodFormField()
        ];
    }

    public static function getItemsRepeater(): Repeater
    {
        return Repeater::make('orderPresentations')
            ->label('Presentaciones Del Pedido')
            ->relationship()
            ->schema([
                static::getPresentationsFormField(),
                static::getQuantityFormField(),
                static::getUnitPriceFormField(),
                static::getSubTotalUnitPriceFormField(),
                static::getUnitPriceWithoutIvaFormField(),
                static::getSubTotalUnitPriceWithoutIvaFormField(),
                static::getUnitCostFormField(),
                static::getSubTotalUnitCostFormField(),
            ])
            ->columns(4)
            ->itemLabel(fn(array $state): ?string => Presentation::find($state['presentation_id'])->name ?? null)
            ->addActionLabel('Agregar otra presentación');
    }

    public static function getCalculatePayFieldset(): Fieldset
    {
        return Fieldset::make('Calcular el total del pedido')
            ->schema([
                static::getExchangeRateFormField(),
                static::getIvaFormField(),
                static::getTotalPriceUsdWithoutIvaFormField(),
                static::getTotalPriceUsdFormField(),
                static::getTotalPriceBsFormField(),

                static::getTotalCostUsdFormField(),
                static::getTotalCostBsFormField(),
                static::getTotalPriceBsWithoutIvaFormField(),

                static::getActionCalcularTotalsFormField()
            ])
            ->columns(5);
    }

    public static function getBuyerFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('client_id')
            ->relationship(
                'buyer',
                'name',
                // modifyQueryUsing: fn(Builder $query) => $query->whereHas('roles', function (Builder $query) {
                //     // return $query->where('level', '>', Role::LEVEL_ADMIN);
                // })
            )
            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name} - {$record->identification_card}")
            ->searchable(['name'])
            ->preload()
            ->required();
    }

    public static function getPaymentMethodFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('payment_method')
            ->required()
            ->label('Método de pago')
            ->options(PaymentMethod::all()->pluck('name', 'name'));
    }

    public static function getPresentationsFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('presentation_id')
            ->label('Presentación')
            ->relationship('presentation', 'name')
            ->searchable()
            ->preload()
            ->live()
            ->afterStateUpdated(function ($state, Set $set, Get $get) {

                $presentation = Presentation::find($state);
                $unitPriceWithoutIva = round($presentation->price / (1.16), 2);

                $set('quantity', 1 ?? null);

                $set('unit_price', $presentation?->price ?? null);
                $set('unit_price_without_iva', $unitPriceWithoutIva ?? null);
                $set('unit_cost', $presentation?->cost ?? null);

                $set('sub_total_unit_price', $get('quantity') * $get('unit_price') ?? null);
                $set('sub_total_unit_price_without_iva', $get('quantity') * $get('unit_price_without_iva') ?? null);
                $set('sub_total_unit_cost', $get('quantity') * $get('unit_cost') ?? null);

                $set('../../amount_iva', null);

                $set('../../total_price_bs', null);
                $set('../../total_price_usd', null);

                $set('../../total_price_bs_without_iva', null);
                $set('../../total_price_usd_without_iva', null);

                $set('../../total_cost_bs', null);
                $set('../../total_cost_usd', null);
            })
            ->distinct()
            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
            ->required();
    }

    public static function getQuantityFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('quantity')
            ->label('Cantidad')
            ->live(debounce: 800)
            ->numeric()
            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                $set('sub_total_unit_price', $state * $get('unit_price') ?? null);
                $set('sub_total_unit_price_without_iva', $state * $get('unit_price_without_iva') ?? null);
                $set('sub_total_unit_cost', $state * $get('unit_cost') ?? null);

                $set('../../amount_iva', null);

                $set('../../total_price_bs', null);
                $set('../../total_price_usd', null);

                $set('../../total_price_bs_without_iva', null);
                $set('../../total_price_usd_without_iva', null);

                $set('../../total_cost_bs', null);
                $set('../../total_cost_usd', null);
            })
            ->required();
    }

    public static function getUnitPriceFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('unit_price')
            ->label('Precio Unitario')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required()
            ->hidden();
    }

    public static function getSubTotalUnitPriceFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('sub_total_unit_price')
            ->label('Sub Total')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required()
            ->hidden();
    }

    public static function getUnitPriceWithoutIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('unit_price_without_iva')
            ->label('Precio Unitario Sin IVA')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required();
    }

    public static function getSubTotalUnitPriceWithoutIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('sub_total_unit_price_without_iva')
            ->label('Sub Total Sin IVA')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required();
    }

    public static function getUnitCostFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('unit_cost')
            ->label('Costo Unitario')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required()
            ->hidden();
    }

    public static function getSubTotalUnitCostFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('sub_total_unit_cost')
            ->label('Sub Total Costo Unitario')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required()
            ->hidden();
    }

    public static function getExchangeRateFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('exchange_rate')
            ->default(function () {
                return ExchangeRate::first()->exchange_rate;
            })
            ->readOnly()
            // ->disabled(true)
            ->label('Tasa de cambio')
            ->live()
            ->numeric()
            ->prefix('Bs')
            ->required();
    }

    public static function getIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('amount_iva')
            ->label('IVA 16%')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required();
    }

    public static function getTotalPriceBsFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_price_bs')
            ->label('Total en Bs')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('Bs')
            ->required();
    }

    public static function getTotalPriceUsdFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_price_usd')
            ->label('Total en $')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required();
    }

    public static function getTotalPriceBsWithoutIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_price_bs_without_iva')
            ->label('Total en Bs sin IVA')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('Bs')
            ->required()
            ->hidden();
    }

    public static function getTotalPriceUsdWithoutIvaFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_price_usd_without_iva')
            ->label('Total en $ sin IVA')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('$')
            ->required();
    }

    public static function getTotalCostBsFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_cost_bs')
            ->label('Costo Total en Bs')
            ->disabled()
            ->dehydrated()
            ->live()
            ->numeric()
            ->prefix('Bs')
            ->required()
            ->hidden();
    }

    public static function getTotalCostUsdFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('total_cost_usd')
            ->label('Costo Total en $')
            ->disabled()
            ->dehydrated(true)
            ->live()
            ->numeric()
            ->prefix('$')
            ->required()
            ->hidden();
    }

    public static function getActionCalcularTotalsFormField(): Forms\Components\Actions
    {
        return Forms\Components\Actions::make([
            Forms\Components\Actions\Action::make('calcular')
                ->label('Calcular totales')
                ->action(function (Set $set, $state, Get $get) {
                    $totalPriceUsd = 0;
                    $totalPriceUsdWithoutIva = 0;
                    $totalCostUsd = 0;
                    $iva = 0;

                    foreach ($get("orderPresentations") as $key => $presentation) {
                        $totalPriceUsd += $presentation['sub_total_unit_price'];
                        $totalPriceUsdWithoutIva += $presentation['sub_total_unit_price_without_iva'];
                        $totalCostUsd += $presentation['sub_total_unit_cost'];
                    }

                    $iva = $totalPriceUsd - ($totalPriceUsd / 1.16);

                    $set('amount_iva', round($iva, 2));
                    $set('total_price_usd', round($totalPriceUsd, 2));
                    $set('total_price_bs', round($totalPriceUsd * $get('exchange_rate'), 2));
                    $set('total_price_usd_without_iva', round($totalPriceUsdWithoutIva, 2));
                    $set('total_price_bs_without_iva',  round($totalPriceUsdWithoutIva * $get('exchange_rate'), 2));
                    $set('total_cost_usd', round($totalCostUsd, 2));
                    $set('total_cost_bs', round($totalCostUsd * $get('exchange_rate'), 2));
                })
        ]);
    }
}

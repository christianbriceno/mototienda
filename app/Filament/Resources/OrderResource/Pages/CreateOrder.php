<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderPresentation;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = OrderResource::class;

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(false),
            ])
            ->columns(null);
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Comprador')
                ->description('Selecciona el comprador y dale un estatus al pedido')
                ->schema(
                    [
                        Section::make()->schema(OrderResource::getDetailsFormSchema())->columns(),
                    ]
                ),

            Step::make('Pedido')
                ->description('Agregue las presentaciones del pedido')
                ->schema([
                    OrderResource::getItemsRepeater(),
                    OrderResource::getCalculatePayFieldset()
                ]),
        ];
    }
}

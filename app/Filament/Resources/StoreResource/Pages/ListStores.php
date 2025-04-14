<?php

namespace App\Filament\Resources\StoreResource\Pages;

use App\Filament\Imports\StoreImporter;
use App\Filament\Resources\StoreResource;
use App\Policies\StorePolicy;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListStores extends ListRecords
{
    protected static string $resource = StoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(StoreImporter::class)
                ->visible(fn(): bool => auth()->user()->can('create Store', StorePolicy::class))
        ];
    }
}

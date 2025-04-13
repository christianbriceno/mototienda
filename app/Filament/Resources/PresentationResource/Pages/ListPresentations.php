<?php

namespace App\Filament\Resources\PresentationResource\Pages;

use App\Filament\Imports\PresentationImporter;
use App\Filament\Resources\PresentationResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListPresentations extends ListRecords
{
    protected static string $resource = PresentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(PresentationImporter::class)
        ];
    }
}

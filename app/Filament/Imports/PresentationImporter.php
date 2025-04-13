<?php

namespace App\Filament\Imports;

use App\Models\Presentation;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PresentationImporter extends Importer
{
    protected static ?string $model = Presentation::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('price')
                ->requiredMapping()
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }

                    $state = preg_replace('/,/', '.', $state);
                    $state = floatval($state);

                    return round($state, precision: 2);
                })
                ->rules(['required', 'numeric']),
            ImportColumn::make('cost')
                ->requiredMapping()
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }

                    $state = preg_replace('/,/', '.', $state);
                    $state = floatval($state);

                    return round($state, precision: 2);
                })
                ->rules(['required', 'numeric']),
            ImportColumn::make('stock')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Presentation
    {
        return Presentation::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'code' => $this->data['code'],
        ]);

        return new Presentation();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your presentation import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

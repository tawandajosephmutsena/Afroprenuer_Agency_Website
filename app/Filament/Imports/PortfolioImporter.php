<?php

namespace App\Filament\Imports;

use App\Models\Portfolio;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PortfolioImporter extends Importer
{
    protected static ?string $model = Portfolio::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('description')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('client_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('service_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('completion_date')
                ->rules(['date']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('url'),
            ImportColumn::make('gallery'),
            ImportColumn::make('sort_order')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Portfolio
    {
        // return Portfolio::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Portfolio();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your portfolio import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

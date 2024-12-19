<?php

namespace App\Filament\Imports;

use App\Models\Task;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class TaskImporter extends Importer
{
    protected static ?string $model = Task::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('description'),
            ImportColumn::make('status')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('priority')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('due_date')
                ->rules(['date']),
            ImportColumn::make('project')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('parent')
                ->relationship(),
            ImportColumn::make('order')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('progress')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('completed_at')
                ->rules(['datetime']),
        ];
    }

    public function resolveRecord(): ?Task
    {
        // return Task::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Task();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your task import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

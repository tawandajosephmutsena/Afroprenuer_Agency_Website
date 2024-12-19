<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

use App\Filament\Resources\ProjectResource\Widgets\StatsOverviewWidget;


class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => ListRecords\Tab::make('All Projects')
                ->icon('heroicon-o-rectangle-stack'),
            'planning' => ListRecords\Tab::make('Planning')
                ->icon('heroicon-o-pencil-square')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'planning')),
            'in_progress' => ListRecords\Tab::make('In Progress')
                ->icon('heroicon-o-play')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'in_progress')),
            'on_hold' => ListRecords\Tab::make('On Hold')
                ->icon('heroicon-o-pause')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'on_hold')),
            'completed' => ListRecords\Tab::make('Completed')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
        ];
    }
}
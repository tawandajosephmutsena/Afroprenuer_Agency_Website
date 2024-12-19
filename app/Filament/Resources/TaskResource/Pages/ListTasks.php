<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Components\NestedTasks;
use App\Filament\Resources\TaskResource;
use App\Filament\Resources\TaskResource\Widgets\StatsOverview;
use Filament\Actions;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Tables\Columns\Layout\View;
use Illuminate\Console\View\Components\Task;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getViewComponents(): array
{
    return [
        'nested-tasks' => NestedTasks::class,
    ];
}

protected function getTableView(): View
    {
        return view('filament.resources.task-resource.pages.list-tasks', [
            'tasks' => Task::whereNull('parent_id')->with('subtasks')->get()
        ]);
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Urgent' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('priority', '=', 'urgent')),
            'High' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('priority', '=', 'high')),
            'Medium' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('priority', '=', 'medium')),
            'Low' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('priority', '=', 'low')),
        ];
    }
}
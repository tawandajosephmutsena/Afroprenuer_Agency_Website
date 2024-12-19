<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class KanbanStats extends BaseWidget
{
    // Define the protected property for project selection
    protected ?string $selectedProject = null;

    protected static ?int $sort = 5;


    // Add this if you want to filter by project
    public function filterByProject(?string $projectId): void
    {
        $this->selectedProject = $projectId;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Tasks', Task::count())
                ->description('Total number of tasks')
                ->color('primary')
                ->icon('heroicon-o-document-text'),

            Stat::make('Completed Tasks', Task::where('status', 'done')->count())
                ->description('Tasks marked as done')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('In Progress', Task::where('status', 'in_progress')->count())
                ->description('Tasks currently being worked on')
                ->color('warning')
                ->icon('heroicon-o-clock'),
        ];
    }

    public function render(): View
    {
        return view('filament/widgets/kanban-stats', [
            'stats' => $this->getStats(),
        ]);
    }
}
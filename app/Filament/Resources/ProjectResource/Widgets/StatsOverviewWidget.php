<?php

namespace App\Filament\Resources\ProjectResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Project;



class StatsOverviewWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Projects', Project::count())
                ->description('Total projects in the system')
                ->icon('heroicon-o-folder'),

            Card::make('In Progress', Project::where('status', 'in_progress')->count())
                ->description('Currently active projects')
                ->color('primary')
                ->icon('heroicon-o-arrow-trending-up'),

            Card::make('Completed Projects', Project::where('status', 'completed')->count())
                ->description('Successfully completed projects')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Card::make('Average Progress', Project::avg('progress') . '%')
                ->description('Overall project completion rate')
                ->color('secondary')
                ->icon('heroicon-o-chart-bar'),

            Card::make('Clients Involved', Project::distinct('client_id')->count())
                ->description('Number of unique clients')
                ->color('warning')
                ->icon('heroicon-o-user-group'),
        ];
    }
}
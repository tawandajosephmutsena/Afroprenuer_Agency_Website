<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProjectStats extends BaseWidget

{
    protected static ?int $sort = 4;

    protected function getCards(): array
    {
        return [
            Card::make('Total Projects', Project::count())
                ->description('Total projects in the system')
                ->icon('heroicon-o-folder'),

            Card::make('Projects in Progress', Project::where('status', 'in_progress')->count())
                ->description('Projects currently active')
                ->color('primary')
                ->icon('heroicon-o-arrow-trending-up'),

            Card::make('Projects On Hold', Project::where('status', 'on_hold')->count())
                ->description('Projects delayed or paused')
                ->color('danger')
                ->icon('heroicon-o-pause-circle'),

            Card::make('Projects Completed', Project::where('status', 'completed')->count())
                ->description('Completed projects')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTasks extends BaseWidget
{
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()->orderBy('created_at', 'desc')->take(5)
            )
            ->columns([

                    Tables\Columns\TextColumn::make('title')
                        ->weight('medium')
                        ->grow(false),

                    Tables\Columns\TextColumn::make('assignee.name')
                        ->color('secondary')
                        ->grow(false),


                        Tables\Columns\TextColumn::make('project.name')
                            ->color('secondary'),

                        Tables\Columns\TextColumn::make('due_date')
                            ->date('M d')
                            ->color('danger'),


            ])
            ->paginated(false)
            ->striped();
    }
}
<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Pages\Dashboard;
use Illuminate\Support\Carbon;
use Filament\Actions\ActionGroup;
use Illuminate\Support\Facades\DB;
use Filament\Support\Colors\Color;
use Filament\Actions\CreateAction;
use Illuminate\Support\Collection;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        // Get tasks created in the last 30 days
        $thirtyDaysAgo = now()->subDays(30);

        // Calculate daily tasks for the chart
        $dailyTasks = Task::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');

        // Calculate completion rate
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'done')->count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

        // Get tasks by priority
        $tasksByPriority = Task::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        // Calculate overdue tasks
        $overdueTasks = Task::where('due_date', '<', now())
            ->where('status', '!=', 'done')
            ->count();

        // Calculate tasks added this week vs last week
        $thisWeekTasks = Task::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $lastWeekTasks = Task::whereBetween('created_at', [
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek()
        ])->count();
        $weeklyGrowth = $lastWeekTasks > 0
            ? round((($thisWeekTasks - $lastWeekTasks) / $lastWeekTasks) * 100, 1)
            : 0;

        return [
            // Total Tasks with trend chart
            Stat::make('Total Tasks', $totalTasks)
                ->description('All time tasks')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart($dailyTasks->values()->toArray())
                ->icon('heroicon-o-document-text'),

            // Completion Rate with trend
            Stat::make('Completion Rate', $completionRate . '%')
                ->description($completedTasks . ' completed out of ' . $totalTasks)
                ->color($completionRate >= 70 ? 'success' : ($completionRate >= 50 ? 'warning' : 'danger'))
                ->icon('heroicon-o-check-circle')
                ->chart([
                    $completedTasks,
                    $totalTasks - $completedTasks
                ]),

           // Tasks By Priority
           Stat::make('Tasks by Priority', function() use ($tasksByPriority) {
            $priorityLabels = [
                'high' => [
                    'label' => 'High',
                    'color' => 'text-danger-500'
                ],
                'medium' => [
                    'label' => 'Medium',
                    'color' => 'text-warning-500'
                ],
                'low' => [
                    'label' => 'Low',
                    'color' => 'text-success-500'
                ],
                'urgent' => [
                    'label' => 'Urgent',
                    'color' => 'text-danger-600'
                ]
            ];

            return new \Illuminate\Support\HtmlString(
                collect($tasksByPriority)
                    ->map(fn($count, $priority) =>
                        "<span class='text-xs {$priorityLabels[$priority]['color']}'>" .
                        ($priorityLabels[$priority]['label'] ?? ucfirst($priority)) .
                        "</span>: " .
                        "<span class='{$priorityLabels[$priority]['color']}'>{$count}</span>"
                    )->implode(' <span class="text-xs">|</span> ')
            );
        })
        ->description('Distribution across priority levels')
        ->color('info')
        ->icon('heroicon-o-flag'),
//->icon('heroicon-o-flag')
//->extraAttributes(['style' => 'white-space: nowrap']),

            // Weekly Growth
            Stat::make('Weekly Growth', ($weeklyGrowth >= 0 ? '+' : '') . $weeklyGrowth . '%')
                ->description($thisWeekTasks . ' tasks this week')
                ->descriptionIcon($weeklyGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($weeklyGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-calendar'),

            // In Progress Tasks
            Stat::make('In Progress', Task::where('status', 'in_progress')->count())
                ->description('Tasks currently being worked on')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            // Overdue Tasks
            Stat::make('Overdue Tasks', $overdueTasks)
                ->description('Tasks past due date')
                ->color($overdueTasks > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-exclamation-circle'),

            // Average Completion Time
            Stat::make('Avg. Completion Time', function() {
                $avgDays = Task::whereNotNull('completed_at')
                    ->selectRaw('AVG(CAST((JULIANDAY(completed_at) - JULIANDAY(created_at)) AS INTEGER)) as avg_days')
                    ->first()
                    ->avg_days;

                return $avgDays ? round($avgDays, 1) . ' days' : '0 days';
            })
            ->description('Average time to complete tasks')
            ->color('gray')
            ->icon('heroicon-o-clock'),

            // Tasks Due Soon
            Stat::make('Due Soon', Task::where('due_date', '>=', now())
                ->where('due_date', '<=', now()->addDays(7))
                ->where('status', '!=', 'done')
                ->count())
                ->description('Due in next 7 days')
                ->color('warning')
                ->icon('heroicon-o-bell-alert'),
        ];
    }

    public static function canView(): bool
    {
        return true;
    }

    protected function getPollingInterval(): ?string
    {
        return '15s';
    }
}

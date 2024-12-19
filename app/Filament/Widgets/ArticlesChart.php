<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Article;

class ArticlesChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Publication Trend';
    protected static ?int $sort = 8;

    protected function getType(): string
    {
        return 'line'; // Chart type: 'line', 'bar', 'pie', etc.
    }

    protected function getData(): array
    {
        $trendData = Article::query()
            ->where('is_published', true)
            ->selectRaw('strftime("%Y-%m", published_at) as month')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return [
            'labels' => $trendData->keys()->toArray(), // Months as labels
            'datasets' => [
                [
                    'label' => 'Published Articles',
                    'data' => $trendData->values()->toArray(), // Counts as data
                    'backgroundColor' => '#4CAF50', // Optional: Bar color
                ],
            ],
        ];
    }

}
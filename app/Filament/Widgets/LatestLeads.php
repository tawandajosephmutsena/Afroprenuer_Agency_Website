<?php

namespace App\Filament\Widgets;

use App\Models\Lead;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLeads extends BaseWidget
{
    protected static ?int $sort = 3;


    public function table(Table $table): Table
    {
        return $table
            ->query(
                Lead::query()->orderBy('created_at', 'desc')->take(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                        ->weight('medium')
                        ->grow(false),

                        Tables\Columns\TextColumn::make('last_name')
                        ->weight('medium')
                        ->grow(false)
                        ->sortable(),

                        Tables\Columns\TextColumn::make('service')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'digital-marketing' => 'info',
                            'branding' => 'success',
                            'web-design' => 'warning',
                            'social-media' => 'primary',
                            'content-strategy' => 'secondary',
                            default => 'gray',
                        }),
                        Tables\Columns\TextColumn::make('budget_range'),
                        Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                       
                        ->color('danger')
                        ->sortable(),
               
            ]);
    }
}
<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;


use App\Filament\Components\TaskProgress;

use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\DateTimePicker;

use App\Filament\Exports\TaskExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;

use App\Filament\Imports\TaskImporter;
use Filament\Tables\Actions\ImportAction;

class TaskRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                ->required()
                ->minLength(3)
                ->maxLength(50)
                ->unique(ignoreRecord: true)
                ->autofocus()
                ->placeholder('Enter a short, descriptive title')
                ->helperText('Title should be between 3 and 50 characters')
                ->lazy(),

            Forms\Components\TextInput::make('progress')
                ->label('Task Progress')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->step(1)
                ->default(0),

            Forms\Components\Textarea::make('description')
                ->maxLength(65535),

            Forms\Components\Select::make('status')
                ->options([
                    'backlog' => 'Backlog',
                    'todo' => 'To Do',
                    'in_progress' => 'In Progress',
                    'review' => 'Review',
                    'done' => 'Done',
                ])
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, $set) {
                    if ($state === 'done') {
                        $set('completed_at', now());
                    } else {
                        $set('completed_at', null);
                    }
                }),

            Forms\Components\Select::make('priority')
                ->options([
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                    'urgent' => 'Urgent',
                ])
                ->required(),

            Forms\Components\DatePicker::make('due_date'),

            Forms\Components\DateTimePicker::make('completed_at')
                ->hidden()
                ->dehydrated(),

            Forms\Components\Select::make('project_id')
                ->relationship('project', 'name')
                ->required(),

            Forms\Components\Select::make('parent_id')
                ->relationship('parent', 'title')
                ->label('Parent Task'),

            TaskProgress::make('progress')
                ->label('Task Progress'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(TaskExporter::class)
                ->formats([
        ExportFormat::Csv,]),
        ImportAction::make()
        ->importer(TaskImporter::class),

        Tables\Actions\CreateAction::make(),
        ])

            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('project.name'),

                TextColumn::make('progress')
                    ->label('Progress')
                    ->formatStateUsing(fn (int $state): string => "{$state}%")
                    ->html()
                    ->extraAttributes(function (TextColumn $column, $state) {
                        $color = match (true) {
                            $state >= 80 => 'green',
                            $state >= 50 => 'blue',
                            default => 'red',
                        };

                        return [
                            'style' => "background: linear-gradient(90deg, {$color} {$state}%, transparent {$state}%); padding: 0.5rem; border-radius: 0.25rem;",
                        ];
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'backlog',
                        'danger' => 'todo',
                        'warning' => 'in_progress',
                        'primary' => 'review',
                        'success' => 'done',
                    ]),

                Tables\Columns\BadgeColumn::make('priority')
                    ->colors([
                        'info' => 'low',
                        'success' => 'medium',
                        'warning' => 'high',
                        'danger' => 'urgent',
                    ]),

                Tables\Columns\TextColumn::make('due_date')
                    ->date(),

                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()
                    ->visible(fn ($record) => $record?->status === 'done'),
            ])
            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
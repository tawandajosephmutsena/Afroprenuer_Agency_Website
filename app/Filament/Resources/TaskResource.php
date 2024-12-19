<?php

namespace App\Filament\Resources;


use Filament\Forms;

use App\Models\Note;
use App\Models\Task;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use App\Filament\Exports\TaskExporter;
use App\Filament\Imports\TaskImporter;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Textarea;


use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;

use App\Filament\Components\TaskProgress;
use Filament\Forms\Components\DatePicker;

use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\TaskResource\Pages;

use Filament\Actions\Exports\Enums\ExportFormat;


use App\Filament\Resources\TaskResource\RelationManagers;


class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationGroup = "Project Manager";
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->columns(3)
                    ->schema([


                        Forms\Components\TextInput::make('title')
                        ->required()
                        ->minLength(3)
                        ->maxLength(50)
                        ->unique(ignoreRecord: true)
                        ->autofocus()
                        ->placeholder('Enter a short, descriptive title')
                        ->helperText('Title should be between 3 and 50 characters')
                        ->placeholder('Enter a short, descriptive title')
                        ->helperText('Title should be between 3 and 50 characters')
                        ->lazy(),


                        Forms\Components\Select::make('project_id')
                ->relationship('project', 'name')
                ->required(),

                        Forms\Components\Select::make('assignee_id')
                            ->relationship('assignee', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),

                    Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'title')
                    ->label('Parent Task'),


                Forms\Components\Section::make('Task Details')
                    ->columns(2)
                    ->schema([
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

                        TaskProgress::make('progress')
                        ->label('Task Progress'),

                    ]),


                    Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                 ->columnSpanFull(),


            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->headerActions([
            ExportAction::make()
                ->exporter(TaskExporter::class)
                ->formats([
        ExportFormat::Csv,]),
        ImportAction::make()
        ->importer(TaskImporter::class),
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
            ->actions([ActionGroup::make([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                 ])->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button()
                    ->outlined()
                        ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                    ->exporter(TaskExporter::class),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Section::make('Task Overview')
                ->schema([
                    TextEntry::make('title')
                        ->label('Task Title')
                        ->weight('bold'),

                    TextEntry::make('project.name')
                        ->label('Project'),

                    TextEntry::make('assignee.name')
                        ->label('Assigned To')
                        ->default('Unassigned'),

                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'backlog' => 'secondary',
                            'todo' => 'danger',
                            'in_progress' => 'warning',
                            'review' => 'primary',
                            'done' => 'success',
                        }),

                    TextEntry::make('priority')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'low' => 'info',
                            'medium' => 'success',
                            'high' => 'warning',
                            'urgent' => 'danger',
                        }),

                    TextEntry::make('progress')
                        ->suffix('%')
                        ->color(fn (int $state): string => match (true) {
                            $state >= 80 => 'success',
                            $state >= 50 => 'warning',
                            default => 'danger',
                        }),

                    TextEntry::make('due_date')
                        ->label('Due Date')
                        ->date(),

                    TextEntry::make('completed_at')
                        ->label('Completed On')
                        ->dateTime()
                        ->visible(fn ($record) => $record?->status === 'done'),
                ])
                ->columns(2),

            Section::make('Description')
                ->schema([
                    TextEntry::make('description')
                        ->columnSpanFull()
                        ->placeholder('No description provided'),
                ]),

            Section::make('Task Hierarchy')
                ->schema([
                    TextEntry::make('parent.title')
                        ->label('Parent Task')
                        ->default('No parent task'),
                ])
        ]);
}

    public static function getRelations(): array
    {
        return [
            RelationManagers\NoteRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
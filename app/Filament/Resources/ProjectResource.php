<?php

namespace App\Filament\Resources;

use actions;
use App\Filament\Exports\ProjectExporter;
use App\Filament\Imports\ProjectImporter;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;

use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Filament\Resources\ProjectResource\RelationManagers\NoteRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\TaskRelationManager;

use App\Models\Project;



use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;


use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;

use Filament\Tables;
use Filament\Tables\Actions\Action;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;


use Filament\Tables\Actions\ImportAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;





class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = "Project Manager";
    protected static ?int $navigationSort = 2;



    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make("Project Details")
                        ->schema([

                            Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                            Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpan(2)
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'heading',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'table',
                                'undo',
                            ]),
                    ])
                    ->columns(1),

            ])
            ->columnSpan(['lg' => 2]),

        Forms\Components\Group::make()
            ->schema([
                Forms\Components\Section::make("Project Relations")
                            ->schema([



                    Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required(),

                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date'),
                Forms\Components\Select::make('status')
                    ->options([
                        'planning' => 'Planning',
                        'in_progress' => 'In Progress',
                        'on_hold' => 'On Hold',
                        'completed' => 'Completed',
                    ])
                    ->required(),

                ]),
                ])
                ->columnSpan(['lg' => 1]),
        ])
        ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(ProjectExporter::class)
                    ->formats([ExportFormat::Csv]),
                ImportAction::make()
                    ->importer(ProjectImporter::class),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Project Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label('Client')
                    ->icon('heroicon-m-building-office')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    
                    ->limit(40)
                    ->html()
                    ->searchable(),
                TextColumn::make('date_range')
                    ->label('Timeline')
                    ->getStateUsing(fn (Project $record): string =>
                        $record->start_date->format('M d') .
                        ' - ' .
                        ($record->end_date ? $record->end_date->format('M d, Y') : 'Ongoing'))
                    ->icon('heroicon-m-calendar'),
                TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->color(fn (string $state): string => match ($state) {
                        'planning' => 'warning',
                        'in_progress' => 'primary',
                        'on_hold' => 'danger',
                        'completed' => 'success',
                        default => 'secondary',
                    }),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'planning' => 'Planning',
                        'in_progress' => 'In Progress',
                        'on_hold' => 'On Hold',
                        'completed' => 'Completed',
                    ]),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
            ])

            ->
                actions([ActionGroup::make([
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
                        ->exporter(ProjectExporter::class),
                 ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TaskRelationManager::class,
            NoteRelationManager::class,
        ];
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Project Details')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Project Name')
                                    ->icon('heroicon-o-folder'),
                                TextEntry::make('client.name')
                                    ->label('Client Name')
                                    ->icon('heroicon-o-user-group'),

                            ])
                            ->columns(2),



                            Section::make('About the project')
                            ->schema([
                            TextEntry::make('description')
                                    ->label('Description')
                                    ->markdown(),
                                    ])
                                    ->columns(1),





                        Section::make('Timeline')
                            ->schema([
                                TextEntry::make('start_date')
                                    ->label('Start Date')
                                    ->dateTime('M d, Y')
                                    ->icon('heroicon-o-calendar'),
                                TextEntry::make('end_date')
                                    ->label('End Date')
                                    ->dateTime('M d, Y')
                                    ->suffix(fn ($record) => $record->end_date ? '' : 'Ongoing')
                                    ->icon('heroicon-o-calendar'),
                            ])
                            ->columns(2),
                        Section::make('Status & Progress')
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state) => match ($state) {
                                        'planning' => 'warning',
                                        'in_progress' => 'primary',
                                        'on_hold' => 'danger',
                                        'completed' => 'success',
                                        default => 'secondary',
                                    })
                                    ->icon('heroicon-o-flag'),

                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(2),
                    Section::make('Tasks')
                    ->schema([
                        RepeatableEntry::make('tasks')
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Task Name')
                                    ->columnSpan(3),
                                TextEntry::make('description')
                                    ->label('Description')
                                    ->columnSpan(3),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state) => match ($state) {
                                        'todo' => 'secondary',
                                        'in_progress' => 'primary',
                                        'review' => 'warning',
                                        'completed' => 'success',
                                        default => 'gray',
                                    }),
                                TextEntry::make('priority')
                                    ->label('Priority')
                                    ->badge()
                                    ->color(fn (string $state) => match ($state) {
                                        'low' => 'secondary',
                                        'medium' => 'warning',
                                        'high' => 'primary',
                                        'urgent' => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('due_date')
                                    ->label('Due Date')
                                    ->date('M d, Y'),
                                TextEntry::make('progress')
                                    ->label('Progress')
                                    ->suffix('%'),
                            ])
                            ->columns(3)
                            ->grid(2),
                    ])
                    ->collapsible(),

                Section::make('Notes')
                    ->schema([
                        RepeatableEntry::make('notes')
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Note Title')
                                    ->columnSpan(2),
                                TextEntry::make('content')
                                    ->label('Note Content')
                                    ->html()
                                    ->columnSpan(2),
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('M d, Y H:i'),
                            ])
                            ->columns(3)
                            ->grid(2),
                    ])
                    ->collapsible(),
            ])
            ;


    }





    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


}
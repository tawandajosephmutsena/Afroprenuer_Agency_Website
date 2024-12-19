<?php

namespace App\Filament\Resources\TaskResource\RelationManagers;

use Filament\Forms;
use App\Models\Task;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Filament\Resources\RelationManagers\RelationManager;


class NoteRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $recordTitleAttribute = 'content';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Note Title')
                        ->columnSpan(2),

                    Forms\Components\Select::make('notable_type')
                        ->label('Link to')
                        ->options([
                            Project::class => 'Project',
                            Task::class => 'Task',
                        ])
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('notable_id', null))
                        ->columnSpan(1),

                    Forms\Components\Select::make('notable_id')
                        ->label('Select Item')
                        ->options(function (callable $get) {
                            $type = $get('notable_type');
                            if (!$type) return [];

                            $query = $type::query();

                            // Add specific sorting/filtering based on type
                            if ($type === Project::class) {
                                $query->orderBy('name');
                            } elseif ($type === Task::class) {
                                $query->orderBy('title');
                            }

                            return $query->get()->pluck(
                                $type === Task::class ? 'title' : 'name',
                                'id'
                            );
                        })
                        ->required()
                        ->disabled(fn (callable $get) => !$get('notable_type'))
                        ->searchable()
                        ->preload()
                        ->columnSpan(1),

                    Forms\Components\RichEditor::make('content')
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

                    Forms\Components\TagsInput::make('tags')
                        ->separator(',')
                        ->columnSpan(2),
                ]),
            ]),
        ]);

    }

    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->label('Title'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->formatStateUsing(fn ($state) => $state->format('d M Y'))
                    ->color('gray')
                    ->label('Date Created'),



                TextColumn::make('notable_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string =>
                        Str::of($state)->afterLast('\\')->toString())
                    ->color(fn (string $state): string =>
                        $state === Project::class ? 'success' : 'warning')
                    ->label('Type'),

                TextColumn::make('notable.name')
                    ->label('Linked To')
                    ->getStateUsing(function (Model $record): string {
                        return match (true) {
                            $record->notable instanceof Task => $record->notable->title ?? '',
                            $record->notable instanceof Project => $record->notable->name ?? '',
                            default => ''
                        };
                    })
                    ->icon('heroicon-m-link'),

                TextColumn::make('tags')
                    ->badge()
                    ->separator(',')
                    ->color('primary')
                    ->label('Tags'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
                ]),
            ]);
    }
}
<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Note;
use App\Models\Task;
use App\Models\Project;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\SelectFilter;

class NoteRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

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
        ->defaultSort('created_at', 'desc')
        ->filters([
            SelectFilter::make('notable_type')
                ->label('Type')
                ->options([
                    Project::class => 'Projects',
                    Task::class => 'Tasks',
                ]),
            SelectFilter::make('tags')
                ->multiple()
                ->preload()
                ->relationship('tags', 'name'),
        ])

            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
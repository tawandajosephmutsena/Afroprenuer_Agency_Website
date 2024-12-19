<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Note;
use App\Models\Task;
use Filament\Tables;
use App\Models\Comment;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\ViewAction;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\NoteResource\Pages;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Filament\Resources\NoteResource\RelationManagers;






class NoteResource extends Resource
{
    protected static ?string $model = Note::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = "Project Manager";
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
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
                            ->columnSpan(2)
                            ->nullable(),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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



    public static function infolist(Infolist $infolist): Infolist

{

    return $infolist

        ->schema([

            Section::make('Note Details')

                ->schema([

                    TextEntry::make('title')

                        ->label('Note Title')

                        ->weight(FontWeight::Bold)

                        ->color('primary'),

                    TextEntry::make('notable_type')

                        ->label('Linked To')

                        ->badge()

                        ->color(fn (string $state): string => match ($state) {

                            Project::class => 'success',

                            Task::class => 'warning',

                            default => 'gray'

                        })

                        ->formatStateUsing(fn (string $state): string =>

                            Str::of($state)->afterLast('\\')->toString()),

                    TextEntry::make('notable.name')

                        ->label('Linked Item')

                        ->placeholder('No linked item'),

                    TextEntry::make('created_at')

                        ->label('Created')

                        ->dateTime('F j, Y'),

                    TextEntry::make('content')

                        ->label('Content')

                        ->prose()

                        ->markdown(),

                    TextEntry::make('tags')

                        ->label('Tags')

                        ->badge()

                        ->separator(', ')

                        ->placeholder('No tags'),

                ])

        ]);

}





    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::class,
        ];
    }

    public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
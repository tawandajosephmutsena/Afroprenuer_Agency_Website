<?php

namespace App\Filament\Resources;



use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;



use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Split;

use Filament\Forms;
use Filament\Tables;
use App\Models\Article;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;

use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Exports\ArticleExporter;
use App\Filament\Imports\ArticleImporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\ActionGroup;


use Filament\Actions\Exports\Enums\ExportFormat;
use App\Filament\Resources\ArticleResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;


class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

   // protected static ?string $navigationParentItem = 'Publications';

protected static ?string $navigationGroup = 'Articles and Media';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square'; 



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make("Content")
                            ->schema([
                                Forms\Components\TextInput::make("title")
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn(string $operation, $state, Forms\Set $set) =>
                                            $operation === "create" ? $set("slug", Str::slug($state)) : null
                                    ),
                                Forms\Components\TextInput::make("slug")
                                    ->required()
                                    ->unique(Article::class, "slug", ignoreRecord: true),
                                Forms\Components\Textarea::make("excerpt")
                                    ->rows(3),
                                TiptapEditor::make("content")
                                    ->profile("default")
                                    ->required(),
                            ])
                            ->columns(1),

                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make("Status")
                            ->schema([
                                Forms\Components\Toggle::make("is_published")
                                    ->label("Published")
                                    ->default(false),
                                Forms\Components\DateTimePicker::make("published_at")
                                    ->label("Publish Date")
                                    ->default(now()),
                            ]),


                            Forms\Components\Section::make("Images")
                            ->schema([
                                CuratorPicker::make("featured_image_id")
                                    ->label("Featured Image")
                                    ->buttonLabel("Select Featured Image")
                                    ->relationship("featuredImage", "id")
                                    ->imageResizeTargetWidth(300)
                                    ->constrained(true),
                            ]),


                        Forms\Components\Section::make("Relationships")
                            ->schema([
                                Forms\Components\Select::make("user_id")
                                    ->relationship("user", "name")
                                    ->required(),
                                Forms\Components\Select::make("category_id")
                                    ->relationship("category", "name")
                                    ->required(),
                                Forms\Components\Select::make("tags")
                                    ->multiple()
                                    ->relationship("tags", "name")
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make("name")->required(),
                                        Forms\Components\TextInput::make("slug")->required(),
                                    ]),
                            ]),
                        Forms\Components\Section::make("SEO")
                            ->schema([
                                Forms\Components\TextInput::make("seo_title"),
                                Forms\Components\Textarea::make("seo_description")->rows(3),
                                Forms\Components\TagsInput::make("seo_keywords"),
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
                ->exporter(ArticleExporter::class)
                ->formats([
        ExportFormat::Csv,
                ]),
                ImportAction::make()
                ->importer(ArticleImporter::class),
        ])

            ->columns([
                CuratorColumn::make("featured_image_id")
                    ->label("Image")
                    ->size(40),
                Tables\Columns\TextColumn::make("title")
                    ->searchable()
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make("category.name")
                    ->sortable(),
                Tables\Columns\TextColumn::make("user.name")
                    ->sortable(),
                Tables\Columns\IconColumn::make("is_published")
                    ->boolean(),
                Tables\Columns\TextColumn::make("published_at")
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make("category")
                    ->relationship("category", "name"),
                Tables\Filters\SelectFilter::make("user")
                    ->relationship("user", "name"),

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
                    ->exporter(ArticleExporter::class),
                ]),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Split::make([
                // Left Column: Primary Article Details
                Grid::make(1)
                    ->schema([
                        Section::make('Article Details')
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Title')
                                    ->size(TextEntrySize::Large)
                                    ->weight('bold')
                                    ->color('primary')
                                    ->columnSpanFull(),

                                TextEntry::make('slug')
                                    ->label('Slug')
                                    ->color('secondary')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('published_at')
                                    ->label('Published On')
                                    ->dateTime('F j, Y H:i')
                                    ->color('secondary')
                                    ->columnSpan(1),

                                TextEntry::make('excerpt')
                                    ->label('Excerpt')
                                    ->prose()
                                    ->default('No excerpt available')
                                    ->columnSpanFull(),

                                TextEntry::make('content')
                                    ->label('Full Content')
                                    ->prose()

                                    ->default('No content available')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ]),

                // Right Column: Supplementary Information
                Grid::make(1)
                    ->schema([
                        Section::make('Featured Image')
                            ->schema([
                                ImageEntry::make('featuredImage.path')
                                    ->label('Featured Image')

                                    ->width('400')
                                    ->alignment('center'),
                            ])
                            ->columnSpanFull(),

                        Section::make('Metadata')
                            ->schema([
                                TextEntry::make('category.name')
                                    ->label('Category')
                                    ->badge(),

                                TextEntry::make('user.name')
                                    ->label('Author')
                                    ->icon('heroicon-m-user'),

                                TextEntry::make('is_published')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn ($state) => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn ($state) => $state ? 'Published' : 'Draft'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),

                        Section::make('SEO Information')
                            ->schema([
                                TextEntry::make('seo_title')
                                    ->label('SEO Title')
                                    ->placeholder('No SEO Title')
                                    ->columnSpanFull(),

                                TextEntry::make('seo_description')
                                    ->label('SEO Description')
                                    ->prose()
                                    ->placeholder('No SEO Description')
                                    ->columnSpanFull(),

                                TextEntry::make('seo_keywords')
                                    ->label('Keywords')
                                    ->badge()
                                    ->separator(',')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),

                        Section::make('Related Tags')
                            ->schema([
                                TextEntry::make('tags.name')
                                    ->label('Tags')
                                    ->badge()
                                    ->color('primary')
                                    ->separator(', ')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),
            ])
            ->columnSpanFull(),
        ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
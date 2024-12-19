<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;




use App\Models\Article;
use App\Models\Category;

use Illuminate\Support\Str;
use Filament\Resources\Resource;

use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Exports\ArticleExporter;
use App\Filament\Imports\ArticleImporter;
use Filament\Tables\Actions\ExportAction;

use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ExportBulkAction;


use Filament\Actions\Exports\Enums\ExportFormat;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;


class ArticleRelationManager extends RelationManager
{
    protected static string $relationship = 'articles';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
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
                Tables\Actions\CreateAction::make(),
        ])

            ->columns([
                CuratorColumn::make("featured_image_id")
                    ->label("Image")
                    ->size(40),
                Tables\Columns\TextColumn::make("title")
                    ->searchable()
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

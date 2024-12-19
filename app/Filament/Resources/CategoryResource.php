<?php

namespace App\Filament\Resources;


use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Str;

use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers\ArticleRelationManager;


class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    // protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";
  //  protected static ?string $navigationParentItem = 'Publications';

protected static ?string $navigationGroup = 'Articles and Media';
protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-up'; 


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("name")
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn(
                        string $operation,
                        $state,
                        Forms\Set $set
                    ) => $operation === "create"
                        ? $set("slug", Str::slug($state))
                        : null
                ),

            Forms\Components\TextInput::make("slug")
                ->required()
                ->maxLength(255)
                ->unique(Category::class, "slug", ignoreRecord: true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("slug")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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



    public static function getRelations(): array
{
    return [
        ArticleRelationManager::class,

    ];
}

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCategories::route("/"),
            "create" => Pages\CreateCategory::route("/create"),
            "edit" => Pages\EditCategory::route("/{record}/edit"),
        ];
    }
}
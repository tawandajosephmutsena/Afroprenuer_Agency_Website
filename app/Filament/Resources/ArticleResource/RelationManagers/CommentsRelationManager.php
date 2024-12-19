<?php

namespace App\Filament\Resources\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Hidden;
use Filament\Resources\RelationManagers\RelationManager;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = "comments";

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("user.name")
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make("content")
                ->required()
                ->maxLength(65535),
            Forms\Components\Toggle::make("is_approved")->required(),
            Hidden::make('user_id')
            ->default(auth()->id())
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("user.name"),
                Tables\Columns\TextColumn::make("content")->limit(50),
                Tables\Columns\IconColumn::make("is_approved")->boolean(),
                Tables\Columns\TextColumn::make("created_at")->dateTime(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make("is_approved")])
            ->headerActions([Tables\Actions\CreateAction::make()])
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
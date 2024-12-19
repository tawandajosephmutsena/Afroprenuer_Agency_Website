<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ArticleResource;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
         'Published' => Tab::make()
         ->modifyQueryUsing(fn (Builder $query) => $query->where('is_published', true)),
         'Unpublished' => Tab::make()
         ->modifyQueryUsing(fn (Builder $query) => $query->where('is_published', false)),


        ];
    }
}
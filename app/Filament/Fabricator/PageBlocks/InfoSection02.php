<?php

namespace App\Filament\Fabricator\PageBlocks;

use Illuminate\Support\HtmlString;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Builder\Block;
use Filament\Infolists\Components\TextEntry;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms\Components\Textarea;



class InfoSection02 extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('info-section02')
            ->schema([
                TextInput::make('title')->label('Title')->required(),
                Textarea::make('content') ->rows(5),

            ]) ;
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}
<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class Hero01 extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('hero01')
            ->schema([
                TextInput::make('heading')->label('Title')->required(),
                Textarea::make('content') ->rows(4),
                Textarea::make('button01'),
                Textarea::make('button02'),
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}
<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms\Components\TextInput;

class Stats01 extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('stats01')
            ->schema([
                TextInput::make('total')->label('total')->required()->numeric(),
                TextInput::make('Title'),

                TextInput::make('total2')->label('second total')->required()->numeric(),
                TextInput::make('Title2'),

                TextInput::make('total3')->label('third total')->required()->numeric(),
                TextInput::make('Title3'),
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;

   }
}
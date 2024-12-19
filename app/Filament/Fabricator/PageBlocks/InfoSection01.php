<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;

class InfoSection01 extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('info-section01')
            ->schema([
                TextInput::make('heading')->label('Title')->required(),
                Textarea::make('subhearding'),
                Textarea::make('content') ->rows(2),
            
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}
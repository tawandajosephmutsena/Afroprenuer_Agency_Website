<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Awcodes\Curator\Components\Forms\CuratorPicker;


class CarouselSlider01 extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('carousel-slider01')
            ->schema([
                // Main carousel fields if any

                // Repeater for dynamic slides
                Repeater::make('slides')
                    ->label('Slides')
                    ->schema([
                        CuratorPicker::make('background_image')
                            ->label('Slide Background Image')
                            ->buttonLabel('Choose Image')
                            ->required(),
                        TextInput::make('author')->label('Author'),
                        TextInput::make('title')->label('Title')->required(),
                        TextInput::make('subtitle')->label('Subtitle')->nullable(),
                        Textarea::make('description')->label('Description')->nullable(),
                        Repeater::make('buttons')
                            ->label('Buttons')
                            ->schema([
                                TextInput::make('label')->label('Button Label')->required(),
                                TextInput::make('url')->label('Button URL')->required(),
                            ])
                            ->minItems(1)
                            ->maxItems(2),
                    ])
                    ->minItems(1)
                    ->maxItems(6)  // Allow up to 6 slides
                    ->columnSpanFull()
                    ->reorderableWithButtons()
                     ->collapsible(),
            ]);
    }

    public static function mutateData(array $data): array
    {
        if (!empty($data['slides'])) {
            foreach ($data['slides'] as &$slide) {
                if (!empty($slide['background_image'])) {
                    $media = \Awcodes\Curator\Models\Media::find($slide['background_image']);
                    $slide['background_image_url'] = $media ? $media->url : null;
                }
            }
        }

        return $data;
    }
}
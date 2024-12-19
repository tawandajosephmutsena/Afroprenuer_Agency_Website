<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


use App\Filament\Exports\ServiceExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Actions\Exports\Enums\ExportFormat;

use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\ActionGroup;

use App\Filament\Imports\ServiceImporter;
use Filament\Tables\Actions\ImportAction;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;




class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

   // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   // protected static ?string $navigationParentItem = 'Publications';

protected static ?string $navigationGroup = 'Our Work';
protected static ?string $navigationIcon = 'heroicon-o-sparkles'; 


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('duration')
                    ->numeric(),
                Forms\Components\TextInput::make('service_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('target_audience')
                    ->maxLength(255),
                Forms\Components\Textarea::make('deliverables')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('status')
                    ->required(),

                         // Adding the image upload field
                FileUpload::make('image')
                ->label('Service Image')
                ->image() // Ensures that only image files can be uploaded
                ->directory('services') // Saves the image in the "storage/app/public/services" directory
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->headerActions([
            ExportAction::make()
                ->exporter(ServiceExporter::class)
                ->formats([
        ExportFormat::Csv,]),
        ImportAction::make()
        ->importer(ServiceImporter::class),
        ])

            ->columns([
                 // Display the uploaded image in the table
                 ImageColumn::make('image')
                 ->label('Image')
                 ->circular(), // Displays the image in a circular frame

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_type')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('target_audience')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
                    ->exporter(ServiceExporter::class),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
//
        ];
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Grid::make(1)
                        ->schema([
                            Section::make('Service Details')
                                ->schema([
                                    ImageEntry::make('image')
                                        ->label('Service Image')
                                        ->columnSpanFull()
                                        ->hiddenLabel(),

                                    TextEntry::make('name')
                                        ->label('Service Name')
                                        ->weight('bold')
                                        ->color('primary')
                                        ->size('xl'),

                                    TextEntry::make('description')
                                        ->prose()
                                        ->markdown(),
                                ]),


                        ]),

                    Section::make('Additional Information')
                        ->schema([
                            Section::make('Pricing & Logistics')
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Service Cost')
                                    ->money()
                                    ->color('success')
                                    ->icon('heroicon-m-currency-dollar'),

                                TextEntry::make('duration')
                                    ->label('Duration')
                                    ->badge()
                                    ->color('info')
                                    ->icon('heroicon-m-clock'),

                                TextEntry::make('service_type')
                                    ->label('Service Type')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('target_audience')
                                    ->label('Target Audience')
                                    ->badge()
                                    ->color('secondary'),
                            ]),


                            TextEntry::make('deliverables')
                                ->label('What You\'ll Receive')
                                ->prose()
                                ->markdown(),

                            TextEntry::make('status')
                                ->label('Service Availability')
                                ->badge()
                                ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                                ->icon(fn (bool $state): string => $state ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle'),

                            Grid::make(2)
                                ->schema([
                                    TextEntry::make('created_at')
                                        ->label('Created On')
                                        ->date()
                                        ->color('secondary'),

                                    TextEntry::make('updated_at')
                                        ->label('Last Updated')
                                        ->date()
                                        ->color('secondary'),
                                ]),
                        ]),
                ])  ->columnSpanFull(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageServices::route('/'),
        ];

   }
}
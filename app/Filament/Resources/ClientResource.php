<?php

namespace App\Filament\Resources;

use Filament\Forms;

use Filament\Tables;
use App\Models\Client;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;

use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Exports\ClientExporter;

use App\Filament\Imports\ClientImporter;
use Filament\Forms\Components\TextInput;

use Filament\Tables\Actions\DeleteAction;

use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\Layout\Split;

use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;

use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\ClientResource\Pages;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Filament\Resources\ClientResource\Pages\ManageClients;
use App\Filament\Resources\ClientResource\RelationManagers\ProjectRelationManager;



class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
        protected static ?string $navigationGroup = 'Inquiries & Customers';

        
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->tel(),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('website'),
            ]);
    }


    public static function table(Table $table): Table {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(ClientExporter::class)
                    ->formats([
                        ExportFormat::Csv,
                    ]),
                ImportAction::make()
                    ->importer(ClientImporter::class),
            ])
            ->columns([
                // Use Stack for card layout
                Stack::make([
                    Split::make([
                        TextColumn::make('')->getStateUsing(fn () => 'Client Name:')->weight(FontWeight::Bold),// Label
                        TextColumn::make('name') // Data
                            ->weight(FontWeight::Bold)
                            ->searchable()
                            ->sortable(),
                    ]),

                    Split::make([
                        TextColumn::make('')->getStateUsing(fn () => 'Email Address:')->weight(FontWeight::Bold), // Label
                        TextColumn::make('email') // Data
                            ->icon('heroicon-m-envelope')
                            ->color('primary')
                            ->searchable(),
                    ]),
                    Split::make([
                        TextColumn::make('')->getStateUsing(fn () => 'Phone Number:')->weight(FontWeight::Bold), // Label
                        TextColumn::make('phone') // Data
                            ->icon('heroicon-m-phone')
                            ->searchable(),
                    ]),
                    Split::make([
                        TextColumn::make('')->getStateUsing(fn () => 'Address:')->weight(FontWeight::Bold), // Label
                        TextColumn::make('address') // Data
                            ->searchable(),
                    ]),
                    Split::make([
                        TextColumn::make('')->getStateUsing(fn () => 'Website:')->weight(FontWeight::Bold), // Label
                        TextColumn::make('website') // Data
                            ->searchable(),
                    ]),
                ])
            ])
            ->contentGrid([
                'md' => 1, // 2 columns on medium screens
                'xl' => 2, // 3 columns on extra-large screens
            ])
            ->filters([
                // Add any filters if needed
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(ClientExporter::class),
                ]),
            ]);
    }

    public static function query(): Builder
{
    return parent::query()->with('projects'); // Preload projects relationship
}


    public static function getRelations(): array
{
    return [
        \App\Filament\Resources\ClientResource\RelationManagers\ProjectRelationManager::class,
    ];
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClients::route('/'),

       ];
    }
}
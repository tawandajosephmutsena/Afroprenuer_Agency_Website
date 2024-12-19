<?php
namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Portfolio;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Infolists\Components\Grid;

use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Split;
use Filament\Tables\Actions\ActionGroup;

use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Infolists\Components\Section;

use App\Filament\Exports\PortfolioExporter;
use App\Filament\Imports\PortfolioImporter;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Infolists\Components\TextEntrySize;
use App\Filament\Resources\PortfolioResource\Pages;



class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;
   // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  //  protected static ?string $navigationParentItem = 'Publications';

protected static ?string $navigationGroup = 'Our Work';
protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line'; 


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->label('Client'),
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')
                    ->label('Service'),
                Forms\Components\DatePicker::make('completion_date'),
                Forms\Components\Toggle::make('status')
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->maxLength(255)
                    ->url(),
                FileUpload::make('gallery')
                    ->multiple()
                    ->image()
                    ->imageResizeMode('contain')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->directory('portfolio-galleries')
                    ->columnSpanFull()
                    ->reorderable()
                    ->downloadable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->headerActions([
            ExportAction::make()
                ->exporter(PortfolioExporter::class)
                ->formats([
        ExportFormat::Csv,
                ]),
    ImportAction::make()
    ->importer(PortfolioImporter::class),
        ])

            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client Name')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => $state ?? 'No Client'),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service Name')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => $state ?? 'No Service'),
                Tables\Columns\ImageColumn::make('gallery')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('completion_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
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
                    Tables\Actions\DeleteBulkAction::make()
                ]),
                ExportBulkAction::make()
                    ->exporter(PortfolioExporter::class),

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make()
                        ->schema([
                            Section::make('Portfolio Details')
                                ->schema([
                                    TextEntry::make('title')
                                        ->label('Title')
                                        ->size('large') // Large for emphasis
                                        ->weight('bold')
                                        ->color('primary')
                                        ->columnSpanFull(),

                                    TextEntry::make('description')
                                        ->label('Description')
                                        ->prose()
                                        ->default('No description available')
                                        ->columnSpanFull(),




                                ])
                                ->columnSpanFull(),

                                Section::make('Times')
                                ->schema([
                                    TextEntry::make('created_at')
                                        ->label('Created At')
                                        ->dateTime('F j, Y H:i')
                                        ->color('secondary'),

                                    TextEntry::make('updated_at')
                                        ->label('Last Updated')
                                        ->dateTime('F j, Y H:i')
                                        ->color('secondary'),
                                        ])
                                ->columns(2),

                                Section::make('Links')
                                ->schema([
                                        TextEntry::make('completion_date')
                                        ->label('Completion Date')
                                        ->dateTime('F j, Y')
                                        ->color('secondary')
                                        ->columnSpanFull(),

                                        TextEntry::make('url')
                                        ->label('Portfolio URL')
                                        ->url(fn ($state) => $state)
                                        ->copyable()
                                        ->placeholder('No URL provided')
                                        ->columnSpanFull(),
                                        ])
                                ->columns(2),

                                Section::make('Info')
                                ->schema([
                                        TextEntry::make('client.name')
                                        ->label('Client')
                                        ->badge()
                                        ->color('secondary')
                                        ->columnSpanFull(),

                                    TextEntry::make('service.name')
                                        ->label('Service')
                                        ->badge()
                                        ->color('success')
                                        ->columnSpanFull(),



                                    TextEntry::make('status')
                                        ->label('Status')
                                        ->badge()
                                        ->color(fn ($state) => $state ? 'success' : 'danger')
                                        ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                                        ->columnSpanFull(),
                                ])
                                ->columns(3),
                        ]),

                    // Right Column: Gallery & Metadata
                    Group::make()
                        ->schema([
                            Section::make('Gallery')
                                ->schema([
                                    ImageEntry::make('gallery')
                                    ->label('Gallery Images')
                                    ->height(250) // Reduce the height to fit better
                                    ->width('95%') // Limit width to avoid spanning full space
                                    ->alignment('center'),

                                ])
                                ->columns(1),


                        ]),
                ])
                ->columns(1)
            ;
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePortfolios::route('/')
        ];
    }
}
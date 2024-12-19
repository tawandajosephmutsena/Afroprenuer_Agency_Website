<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use App\Filament\Resources\LeadResource\Actions\MoveToClientsAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;



class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Inquiries & Customers';

   


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Details')
                    ->description('Contact information for the project inquiry')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(20),
                                
                                TextInput::make('address')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),
    
                Section::make('Project Information')
                    ->description('Details about the project and service required')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('service')
                                    ->options([
                                        'digital-marketing' => 'Digital Marketing',
                                        'branding' => 'Branding',
                                        'web-design' => 'Web Design',
                                        'social-media' => 'Social Media Management',
                                        'content-strategy' => 'Content Strategy',
                                        'other' => 'Other',
                                    ])
                                    ->searchable()
                                    ->required(),
                                
                                Select::make('budget_range')
                                    ->options([
                                        '1k-5k' => '$1,000 - $5,000',
                                        '5k-10k' => '$5,000 - $10,000',
                                        '10k-25k' => '$10,000 - $25,000',
                                        '25k-plus' => '$25,000+',
                                    ])
                                    ->required(),
                            ]),
                        Textarea::make('project_details')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
    
                Section::make('Consent')
                    ->schema([
                        Checkbox::make('privacy_agreed')
                            ->label('I agree to the privacy policy and terms of service')
                            ->required(),
                    ]),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                    TextColumn::make('address')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('service')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'digital-marketing' => 'info',
                        'branding' => 'success',
                        'web-design' => 'warning',
                        'social-media' => 'primary',
                        'content-strategy' => 'secondary',
                        default => 'gray',
                    }),
                TextColumn::make('budget_range'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([ActionGroup::make([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                MoveToClientsAction::make(),
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
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
           'view' => Pages\ViewLead::route('/{record}'),
        ];
    }
}
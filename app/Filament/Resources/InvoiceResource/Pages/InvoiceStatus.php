<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages\InvoiceStatus as BaseInvoiceStatus;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Arr;

class InvoiceStatus extends BaseInvoiceStatus
{
    public function table(Table $table): Table
    {
        $locals = config('filament-menus.locals', []);
        $localsTitle = [];
        $schema = [];

        if (is_array($locals)) {
            foreach ($locals as $key => $local) {
                $currentLocale = app()->getLocale();
                $localName = is_array($local) ? Arr::get($local, $currentLocale, $key) : $local;
                $localsTitle[$key] = __('tomato-admin::global.'. $localName);
                $schema[$key] = TextInput::make($key)
                    ->label($localsTitle[$key])
                    ->required();
            }
        }

        return $table
            ->query(static::getModel()::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('color')
                    ->label(__('Color'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->form(function () use ($localsTitle) {
                        $schema = [
                            Grid::make(2)->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->label(__('Name')),
                                TextInput::make('color')
                                    ->required()
                                    ->label(__('Color')),
                                Select::make('status')
                                    ->required()
                                    ->options([
                                        1 => __('Active'),
                                        0 => __('Not Active')
                                    ])
                                    ->label(__('Status'))
                            ])
                        ];

                        if (!empty($localsTitle)) {
                            $schema[] = Grid::make()
                                ->schema($schema);

                            $schema[] = KeyValue::make('name_lang')
                                ->label(__('Names Translations'))
                                ->schema($schema)
                                ->required()
                                ->default(
                                    collect($localsTitle)->mapWithKeys(function ($item, $key) {
                                        return [$key => ''];
                                    })->toArray() ?? []
                                );
                        }

                        return $schema;
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(function ($record) use ($localsTitle) {
                        $schema = [
                            Grid::make(2)->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->label(__('Name')),
                                TextInput::make('color')
                                    ->required()
                                    ->label(__('Color')),
                                Select::make('status')
                                    ->required()
                                    ->options([
                                        1 => __('Active'),
                                        0 => __('Not Active')
                                    ])
                                    ->label(__('Status'))
                            ])
                        ];

                        if (!empty($localsTitle)) {
                            $schema[] = Grid::make()
                                ->schema($schema);
                                
                            $schema[] = KeyValue::make('name_lang')
                                ->label(__('Names Translations'))
                                ->schema($schema)
                                ->required()
                                ->default(is_array($record->name_lang) ? $record->name_lang : []);
                        }

                        return $schema;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
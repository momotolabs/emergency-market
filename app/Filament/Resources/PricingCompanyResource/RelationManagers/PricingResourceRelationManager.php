<?php

namespace App\Filament\Resources\PricingCompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class PricingResourceRelationManager extends RelationManager
{
    protected static string $relationship = 'pricingResource';

    protected static ?string $recordTitleAttribute = 'company.name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('minimum_units')->label('Minimum hours'),
                Forms\Components\TextInput::make('price_cents')->label('Price')
                    ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                        $component->state($state / 100);
                    })
                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->money(prefix: '$', thousandsSeparator: ',', decimalPlaces: 2)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('resource.name'),
                Tables\Columns\TextColumn::make('minimum_units')->label('Minimum hours'),
                Tables\Columns\TextColumn::make('price_cents')->label('Price')->money(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                //                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['price_cents'] *= 100;

                    return $data;
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

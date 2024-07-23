<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Filament\Resources\PricingCompanyResource\RelationManagers\PricingResourceRelationManager;
use App\Filament\Resources\ProviderProfileResource\RelationManagers\ProfileUserRelationManager;
use App\Models\Company;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'far-building';

    protected static ?string $navigationGroup = 'Manage Providers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('General Information')->schema([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\TextInput::make('phone')->required(),
                    Forms\Components\TextInput::make('slug')->required(),
                    Forms\Components\Select::make('state_id')
                        ->relationship('state', 'name')
                        ->reactive(),
                    Forms\Components\Select::make('city_id')
                        ->relationship(
                            'city',
                            'name',
                            fn ($query, $get) => $query->ofCities($get('state_id')))
                        ->reactive(),
                    Forms\Components\TextInput::make('address')->required(),
                    Map::make('address_coordinates')
                        ->reactive()
                        ->defaultZoom(15)
//                        ->autocompleteReverse(true)
                        ->autocomplete('address')
                        ->columnSpan(2),
                ]),
                Forms\Components\Fieldset::make('Social Information')->schema([
                    Forms\Components\TextInput::make('social.youtube_link')->url(),
                    Forms\Components\TextInput::make('social.google_link'),
                    Forms\Components\TextInput::make('social.website_link'),
                ]),
                Forms\Components\Fieldset::make('Parking Information')->schema([
                    Forms\Components\TextInput::make('parking_address')->required(),
                    Forms\Components\TextInput::make('phone')->required(),
                    Forms\Components\TextInput::make('miles')->required(),
                    Map::make('parking_coordinates')
                        ->reactive()
                        ->autocompleteReverse(true)
                        ->autocomplete('parking_address')
                        ->defaultLocation(fn (callable $get) => $get('parking_coordinates'))
                        ->defaultZoom(15)
//                        ->autocompleteReverse(true)
                        ->columnSpan(2),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->rowIndex(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContractsRelationManager::class,
            ProfileUserRelationManager::class,
            PricingResourceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            //            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}

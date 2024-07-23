<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderProfileResource\Pages;
use App\Filament\Resources\ProviderProfileResource\RelationManagers;
use App\Models\ProviderProfile;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ProviderProfileResource extends Resource
{
    protected static ?string $model = ProviderProfile::class;

    protected static ?string $navigationIcon = 'clarity-users-line';

    protected static ?string $navigationGroup = 'Manage Providers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->minLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->rowIndex(),
                Tables\Columns\TextColumn::make('user.email'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CompanyRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProviderProfiles::route('/'),
            //            'create' => Pages\CreateProviderProfile::route('/create'),
            'edit' => Pages\EditProviderProfile::route('/{record}/edit'),
        ];
    }
}

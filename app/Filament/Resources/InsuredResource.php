<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsuredResource\Pages;
use App\Models\Insured;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class InsuredResource extends Resource
{
    protected static ?string $model = Insured::class;

    protected static ?string $navigationLabel = 'Claims';

    protected static ?string $navigationGroup = 'Manage System';

    protected static ?string $navigationIcon = 'clarity-event-solid-badged';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('insurance_company')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('claim_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->rowIndex(),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('insurance_company')->searchable(),
                Tables\Columns\TextColumn::make('claim_number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->sortable()
                    ->dateTime(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListInsureds::route('/'),
            //            'create' => Pages\CreateInsured::route('/create'),
            'view' => Pages\ViewInsured::route('/{record}'),
        ];
    }
}

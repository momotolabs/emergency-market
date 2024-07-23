<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;

use Filament\Tables\Actions\Action;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'clarity-user-line';

    protected static ?string $navigationGroup = 'Manage System';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->rowIndex(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('providerProfile.first_name')->label('First name'),
                Tables\Columns\TextColumn::make('providerProfile.last_name')->label('Last name'),
                Tables\Columns\ViewColumn::make('providerProfile.phone')->view('vendor.filament.tables.columns.links')->label('Phone')->sortable(),
                Tables\Columns\TextColumn::make('company.name')->label('Company'),

                Tables\Columns\IconColumn::make('first_time')->label('Completed')
                    ->boolean()
                    ->falseIcon('clarity-check-circle-line')
                    ->trueIcon('clarity-shield-x-line')
                    ->falseColor('success')
                    ->trueColor('danger')
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()->sortable(),
                Tables\Columns\ViewColumn::make('created_at')->view('vendor.filament.tables.columns.timezone')->sortable()
            ])
            ->filters([
                Tables\Filters\Filter::make('completed')
                    ->query(fn (Builder $query): Builder => $query->where('first_time', true)),
                Tables\Filters\Filter::make('uncompleted')
                    ->query(fn (Builder $query): Builder => $query->where('first_time', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Action::make('sendEmail')->label('Send Email')->url(fn ($record): string => 'mailto:'.$record->email)->color('success')->icon('heroicon-o-mail'),
                //Action::make('call')->label('Call')->action('callPhoneNumber') //(fn ($record): string => 'tel:'.$record)->color('success')->icon('heroicon-o-phone')
            ])
            ->bulkActions([

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
            'index' => Pages\ListUsers::route('/'),
            //            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}

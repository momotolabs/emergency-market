<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SystemEventsResource\Pages;
use App\Models\Company;
use App\Models\Resource as ResourceModel;
use App\Models\SystemEvents;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\HtmlString;

class SystemEventsResource extends Resource
{
    protected static ?string $model = SystemEvents::class;

    protected static ?string $navigationGroup = 'Manage System';

    protected static ?string $navigationIcon = 'clarity-history-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('event_class'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->rowIndex(),
                Tables\Columns\BadgeColumn::make('event_class')->label('Action')->enum(
                    [
                        'resource_created' => 'Resource created',
                        'resource_updated' => 'Resource updated',
                        'parking_created' => 'Parking set',
                        'parking_updated' => 'Parking changed',
                    ]
                )->colors([
                    'primary' => 'resource_created',
                    'success' => 'resource_updated',
                    'b1' => 'parking_created',
                    'warning' => 'parking_updated',
                ])->icons([
                    'clarity-check-circle-solid' => 'resource_created',
                    'clarity-tasks-solid' => 'resource_updated',
                    'clarity-check-circle-line' => 'parking_created',
                    'clarity-tasks-line' => 'parking_updated',
                ]),
                Tables\Columns\TextColumn::make('event_properties')->label('Company')->formatStateUsing(function (string $state) {
                    $data = json_decode($state, true)['attributes'];
                    $resource = isset($data['resource_id']) ? '( '.ResourceModel::find($data['resource_id'])->name.' )
                    ' : '';

                    $name = '<strong>'.Company::find($data['company_id'])->name.'</strong>'.$resource;

                    return new HtmlString($name);
                })->sortable(),
                //
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable(),

            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSystemEvents::route('/'),
            //            'create' => Pages\CreateSystemEvents::route('/create'),
            //            'view' => Pages\EditSystemEvents::route('/{record}'),
            'view' => Pages\ViewEventResource::route('/{record}'),
        ];
    }
}

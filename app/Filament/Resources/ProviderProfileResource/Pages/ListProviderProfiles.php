<?php

namespace App\Filament\Resources\ProviderProfileResource\Pages;

use App\Filament\Resources\ProviderProfileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProviderProfiles extends ListRecords
{
    protected static string $resource = ProviderProfileResource::class;

    protected function getActions(): array
    {
        return [
            //            Actions\CreateAction::make(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50];
    }
}

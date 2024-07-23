<?php

namespace App\Filament\Resources\InsuredResource\Pages;

use App\Filament\Resources\InsuredResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsureds extends ListRecords
{
    protected static string $resource = InsuredResource::class;

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

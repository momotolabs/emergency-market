<?php

namespace App\Filament\Resources\ResourceResource\Pages;

use App\Filament\Resources\ResourceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageResources extends ManageRecords
{
    protected static string $resource = ResourceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

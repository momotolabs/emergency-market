<?php

namespace App\Filament\Resources\InsuredResource\Pages;

use App\Filament\Resources\InsuredResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInsured extends EditRecord
{
    protected static string $resource = InsuredResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

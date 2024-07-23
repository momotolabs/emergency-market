<?php

namespace App\Filament\Resources\ProviderProfileResource\Pages;

use App\Filament\Resources\ProviderProfileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProviderProfile extends EditRecord
{
    protected static string $resource = ProviderProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

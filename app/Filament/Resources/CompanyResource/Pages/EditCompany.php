<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use MStaack\LaravelPostgis\Geometries\Point;

class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $dataPos = json_decode(json_encode($this->record->address_coordinates, true));
        $dataPosPark = json_decode(json_encode($this->record->parking_coordinates, true));

        $data['address_coordinates'] = ['lat' => $dataPos->coordinates[1] ?? 0, 'lng' => $dataPos->coordinates[0] ?? 0];
        $data['parking_coordinates'] = ['lat' => $dataPosPark->coordinates[1] ?? 0, 'lng' => $dataPosPark->coordinates[0] ?? 0];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['address_coordinates'] = new Point($data['address_coordinates']['lat'], $data['address_coordinates']['lng']);
        $data['parking_coordinates'] = new Point($data['parking_coordinates']['lat'], $data['parking_coordinates']['lng']);

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

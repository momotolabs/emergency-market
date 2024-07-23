<?php

namespace App\Filament\Resources\SystemEventsResource\Pages;

use App\Filament\Resources\SystemEventsResource;
use App\Models\Company;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSystemEvents extends ListRecords
{
    protected static string $resource = SystemEventsResource::class;

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        if (filled($searchQuery = $this->getTableSearchQuery())) {
            $companiesId = Company::where('name', 'ilike', '%'.$searchQuery.'%')->get()->pluck('id');

            return $query->whereIn('event_properties->attributes->company_id', $companiesId);
        }

        return $query;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50];
    }
}

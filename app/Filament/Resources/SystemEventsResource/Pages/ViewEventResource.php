<?php

namespace App\Filament\Resources\SystemEventsResource\Pages;

use App\Filament\Resources\SystemEventsResource;
use App\Models\Company;
use App\Models\Resource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;

class ViewEventResource extends ViewRecord
{
    protected static string $resource = SystemEventsResource::class;

    public function render(): View
    {
        $view = null;
        $viewData = [];

        if ($this->record->event_class === 'resource_created' || $this->record->event_class === 'resource_updated') {
            $data = json_decode($this->record->event_properties, true)['attributes'];
            $resources = \DB::table('stored_events')->where('event_properties->attributes->id',
                $data['id'])->get();
            $resource = Resource::find($data['resource_id']);
            $company = Company::find($data['company_id']);
            $viewData = ['company' => $company, 'resource' => $resource, 'resources' => $resources];
            $view = 'show-event-resource';
        }

        if ($this->record->event_class === 'parking_created' || $this->record->event_class === 'parking_updated') {
            $data = json_decode($this->record->event_properties, true)['attributes'];
            $historical = \DB::table('stored_events')->where('event_properties->attributes->company_id',
                $data['company_id'])->where('event_properties->attributes->parking_address', '<>', '')->get();

            $company = Company::find($data['company_id']);
            $viewData = ['company' => $company, 'historical' => $historical];
            $view = 'show-event-parking';
        }

        return view($view, $viewData)->layout('layouts.app');
    }

    public function back()
    {
        return redirect('/admin/system-events');
    }
}

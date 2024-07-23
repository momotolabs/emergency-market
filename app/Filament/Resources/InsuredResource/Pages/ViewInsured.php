<?php

namespace App\Filament\Resources\InsuredResource\Pages;

use App\Filament\Resources\InsuredResource;
use App\Models\InsuredContract;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;

class ViewInsured extends ViewRecord
{
    protected static string $resource = InsuredResource::class;

    public function render(): View
    {
        $contract = InsuredContract::with('insured')->where('insured_id', $this->data['id'])->first();

//        dd($contract->toArray());
        return view('show-insured', ['contract' => $contract]);
    }

    public function back()
    {
        return redirect('/admin/insureds');
    }
}

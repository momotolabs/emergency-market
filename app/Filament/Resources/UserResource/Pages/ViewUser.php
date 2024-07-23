<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;
use App\Models\User;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function render(): View
    {
        $user = User::with('providerProfile')->where('id', $this->data['id']);
        return view('show-user', [$user]);
    }

    public function back()
    {
        return redirect('/admin/users');
    }
}

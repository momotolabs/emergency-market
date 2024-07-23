<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'phosphor-gauge-duotone';

    protected function getHeading(): string
    {
        return 'emergency Market Dashboard';
    }
}

<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;

class FilamentNavigationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                  ->label('Manage Providers')
                  ->icon('clarity-directory-line'),
                NavigationGroup::make()
                  ->label('Manage System')
                  ->icon('heroicon-s-pencil'),
                NavigationGroup::make()
                  ->label('Settings')
                  ->icon('heroicon-s-cog')
                  ->collapsed(),
            ]);
        });
    }
}

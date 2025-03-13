<?php

namespace AbdelhamidErrahmouni\FilamentSelectTreeExtended;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSelectTreeExtendedServiceProvider extends PackageServiceProvider
{
    public static string $name = 'select-tree-extended';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            AlpineComponent::make('filament-select-tree-extended', __DIR__.'/../resources/dist/filament-select-tree-extended.js'),
            Css::make('filament-select-tree-extended-styles', __DIR__.'/../resources/dist/filament-select-tree-extended.css'),
        ], 'abdelhamiderrahmouni/filament-select-tree-extended');
    }
}

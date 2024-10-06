<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Nordecode\FilamentMenuOrganizer\Livewire\CreateCustomLink;
use Nordecode\FilamentMenuOrganizer\Livewire\MenuItems;
use Nordecode\FilamentMenuOrganizer\Livewire\MenuPanel;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentMenuOrganizerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-menu-organizer';

    public static string $viewNamespace = 'filament-menu-organizer';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('organizer/filament-menu-organizer');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName(),
        );

        Livewire::component('menu-builder-items', MenuItems::class);
        Livewire::component('menu-builder-panel', MenuPanel::class);
        Livewire::component('create-custom-link', CreateCustomLink::class);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'nordecode/filament-menu-organizer';
    }

    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('filament-menu-organizer', __DIR__ . '/../resources/dist/filament-menu-organizer.js'),
            Css::make('filament-menu-organizer-styles', __DIR__ . '/../resources/dist/filament-menu-organizer.css'),
        ];
    }

    protected function getMigrations(): array
    {
        return [
            'create_menus_table',
        ];
    }
}

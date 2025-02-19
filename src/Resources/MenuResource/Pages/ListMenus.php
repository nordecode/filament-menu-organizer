<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Resources\MenuResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Nordecode\FilamentMenuOrganizer\Concerns\HasLocationAction;
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;

class ListMenus extends ListRecords
{
    use HasLocationAction;

    public static function getResource(): string
    {
        return FilamentMenuOrganizerPlugin::get()->getResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            $this->getLocationAction(),
        ];
    }
}

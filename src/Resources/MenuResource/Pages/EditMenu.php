<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Resources\MenuResource\Pages;

use Nordecode\FilamentMenuOrganizer\Concerns\HasLocationAction;
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditMenu extends EditRecord
{
    use HasLocationAction;

    protected static string $view = 'filament-menu-organizer::edit-record';

    public static function getResource(): string
    {
        return FilamentMenuOrganizerPlugin::get()->getResource();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema($form->getComponents()),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            $this->getLocationAction(),
        ];
    }
}

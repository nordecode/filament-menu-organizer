<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Livewire;

use Nordecode\FilamentMenuOrganizer\Enums\LinkTarget;
use Nordecode\FilamentMenuOrganizer\Models\Menu;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateCustomLink extends Component implements HasForms
{
    use InteractsWithForms;

    public Menu $menu;

    public string $title = '';

    public string $url = '';

    public string $target = LinkTarget::Self->value;

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string'],
            'url' => ['required', 'string'],
            'target' => ['required', 'string', Rule::in(LinkTarget::cases())],
        ]);

        $this->menu
            ->menuItems()
            ->create([
                'title' => $this->title,
                'url' => $this->url,
                'target' => $this->target,
                'order' => $this->menu->menuItems->max('order') + 1,
            ]);

        Notification::make()
            ->title(__('filament-menu-organizer::menu-organizer.notifications.created.title'))
            ->success()
            ->send();

        $this->reset('title', 'url', 'target');
        $this->dispatch('menu:created');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('filament-menu-organizer::menu-organizer.form.title'))
                    ->required(),
                TextInput::make('url')
                    ->label(__('filament-menu-organizer::menu-organizer.form.url'))
                    ->required(),
                Select::make('target')
                    ->label(__('filament-menu-organizer::menu-organizer.open_in.label'))
                    ->options(LinkTarget::class)
                    ->default(LinkTarget::Self),
            ]);
    }

    public function render(): View
    {
        return view('filament-menu-organizer::livewire.create-custom-link');
    }
}

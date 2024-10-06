<form wire:submit="save">
    <x-filament::section
        :heading="__('filament-menu-organizer::menu-organizer.custom_link')"
        :collapsible="true"
        :persist-collapsed="true"
        id="create-custom-link"
    >
        {{ $this->form }}

        <x-slot:footerActions>
            <x-filament::button type="submit">
                {{ __('filament-menu-organizer::menu-organizer.actions.add.label') }}
            </x-filament::button>
        </x-slot:footerActions>
    </x-filament::section>
</form>

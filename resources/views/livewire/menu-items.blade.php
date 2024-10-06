<div>
    @if($this->menuItems->isNotEmpty())
        <ul
            ax-load
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-menu-organizer', 'nordecode/filament-menu-organizer') }}"
            x-data="menuBuilder({ parentId: 0 })"
            class="space-y-2"
        >
            @foreach($this->menuItems as $menuItem)
                <x-filament-menu-organizer::menu-item
                    :item="$menuItem"
                />
            @endforeach
        </ul>
    @else
        <x-filament-tables::empty-state
            icon="heroicon-o-document"
            :heading="trans('filament-menu-organizer::menu-organizer.items.empty.heading')"
        />
    @endif

    <x-filament-actions::modals />
</div>

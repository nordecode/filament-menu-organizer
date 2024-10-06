<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Enums;

use Filament\Support\Contracts\HasLabel;

enum LinkTarget: string implements HasLabel
{
    case Self = '_self';

    case Blank = '_blank';

    case Parent = '_parent';

    case Top = '_top';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Self => __('filament-menu-organizer::menu-organizer.open_in.options.self'),
            self::Blank => __('filament-menu-organizer::menu-organizer.open_in.options.blank'),
            self::Parent => __('filament-menu-organizer::menu-organizer.open_in.options.parent'),
            self::Top => __('filament-menu-organizer::menu-organizer.open_in.options.top'),
        };
    }
}

<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Contracts;

interface MenuPanelable
{
    public function getMenuPanelName(): string;

    public function getMenuPanelTitleColumn(): string;

    public function getMenuPanelUrlUsing(): callable;

    public function getMenuPanelModifyQueryUsing(): callable;
}

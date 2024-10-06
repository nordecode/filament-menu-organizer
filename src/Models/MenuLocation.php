<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Models;

use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $menu_id
 * @property string $location
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Nordecode\FilamentMenuOrganizer\Models\Menu $menu
 */
class MenuLocation extends Model
{
    protected $guarded = [];

    public function getTable(): string
    {
        return config('filament-menu-organizer.tables.menu_locations', parent::getTable());
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(FilamentMenuOrganizerPlugin::get()->getMenuModel());
    }
}

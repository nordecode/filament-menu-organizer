<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Models;

use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property bool $is_visible
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Nordecode\FilamentMenuOrganizer\Models\MenuLocation[] $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Nordecode\FilamentMenuOrganizer\Models\MenuItem[] $menuItems
 * @property-read int|null $menuItems_count
 */
class Menu extends Model
{
    protected $guarded = [];

    public function getTable(): string
    {
        return config('filament-menu-organizer.tables.menus', parent::getTable());
    }

    protected function casts(): array
    {
        return [
            'is_visible' => 'bool',
        ];
    }

    public function locations(): HasMany
    {
        return $this->hasMany(FilamentMenuOrganizerPlugin::get()->getMenuLocationModel());
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(FilamentMenuOrganizerPlugin::get()->getMenuItemModel())
            ->whereNull('parent_id')
            ->orderBy('parent_id')
            ->orderBy('order')
            ->with('children');
    }

    public static function location(string $location): ?self
    {
        return FilamentMenuOrganizerPlugin::get()
            ->getMenuLocationModel()::with(['menu' => fn (Builder $query) => $query->where('is_visible', true)])
            ->where('location', $location)
            ->first()?->menu;
    }
}

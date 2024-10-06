<?php

declare(strict_types=1);

namespace Nordecode\FilamentMenuOrganizer\Models;

use Nordecode\FilamentMenuOrganizer\Contracts\MenuPanelable;
use Nordecode\FilamentMenuOrganizer\Enums\LinkTarget;
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $menu_id
 * @property int|null $parent_id
 * @property string $title
 * @property string|null $url
 * @property string|null $type
 * @property string|null $target
 * @property int $order
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|MenuItem[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Model|MenuPanelable|null $linkable
 * @property-read \Nordecode\FilamentMenuOrganizer\Models\Menu $menu
 * @property-read \Nordecode\FilamentMenuOrganizer\Models\MenuItem|null $parent
 */
class MenuItem extends Model
{
    protected $guarded = [];

    public function getTable(): string
    {
        return config('filament-menu-organizer.tables.menu_items', parent::getTable());
    }

    protected function casts(): array
    {
        return [
            'order' => 'int',
            'target' => LinkTarget::class,
        ];
    }

    protected static function booted(): void
    {
        static::deleted(function (self $menuItem) {
            $menuItem->children->each->delete();
        });
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(FilamentMenuOrganizerPlugin::get()->getMenuModel());
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')
            ->with('children')
            ->orderBy('order');
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function url(): Attribute
    {
        return Attribute::get(function (?string $value) {
            return match (true) {
                $this->linkable instanceof MenuPanelable => $this->linkable->getMenuPanelUrlUsing()($this->linkable),
                default => $value,
            };
        });
    }

    protected function type(): Attribute
    {
        return Attribute::get(function () {
            return match (true) {
                $this->linkable instanceof MenuPanelable => $this->linkable->getMenuPanelName(),
                default => __('filament-menu-organizer::menu-organizer.custom_link'),
            };
        });
    }
}

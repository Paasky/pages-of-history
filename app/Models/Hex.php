<?php /** @noinspection PhpUnused */

namespace App\Models;

use App\Casts\ImprovementCast;
use App\Casts\ResourceCast;
use App\Coordinate;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use App\Managers\MapManager;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Hex extends Model
{
    use HasFactory;
    use PohModel;

    protected $fillable = [
        'region_id',
        'x',
        'y',
        'domain',
        'surface',
        'elevation',
        'feature',
        'resource',
        'resource_amount',
        'improvement',
        'improvement_health',
        'knowledge',
        'events',
    ];

    protected $casts = [
        'domain' => Domain::class,
        'surface' => Surface::class,
        'feature' => Feature::class,
        'resource' => ResourceCast::class,
        'improvement' => ImprovementCast::class,
    ];

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function getCoordinateAttribute(): Coordinate
    {
        return new Coordinate($this->x, $this->y);
    }

    /**
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public function getYieldModifiersAttribute(): Collection
    {
        return $this->domain->yieldModifiers()
            ->merge($this->surface->yieldModifiers())
            ->merge($this->feature?->yieldModifiers() ?: [])
            ->merge($this->resource?->yieldModifiers() ?: [])
            ->merge($this->improvement?->yieldModifiers() ?: [])
            ->merge($this->units->map(fn(Unit $unit) => $unit->yield_modifiers)->flatten());
    }

    public function adjacentHexes(int $distance = 1): Builder|static
    {
        return static::whereMapId($this->map_id)
            ->where(function (Builder $q) use ($distance) {
                $adjacentCoords = MapManager::adjacentCoordinates($this->coordinate, $this->map->size, $distance);
                foreach ($adjacentCoords as $coords) {
                    $q->orWhere($coords->toXYArray());
                }
            });
    }

    /**
     * @return Collection<int, Hex>
     */
    public function getAdjacentHexesAttribute(): Collection
    {
        return $this->adjacentHexes()->get();
    }
}

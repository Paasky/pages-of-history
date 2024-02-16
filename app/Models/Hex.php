<?php /** @noinspection PhpUnused */

namespace App\Models;

use App\Casts\ImprovementCast;
use App\Casts\ResourceCast;
use App\Coordinate;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use App\Improvements\ImprovementType;
use App\Managers\MapManager;
use App\Resources\ResourceType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Database\Factories\HexFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Hex
 *
 * @property int $id
 * @property int $map_id
 * @property int $x
 * @property int $y
 * @property Surface $surface
 * @property int $elevation
 * @property Feature|null $feature
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Coordinate $coordinate
 * @property-read Map $map
 * @property-read Collection<int, Unit> $units
 * @property-read int|null $units_count
 * @method static HexFactory factory($count = null, $state = [])
 * @method static Builder|Hex newModelQuery()
 * @method static Builder|Hex newQuery()
 * @method static Builder|Hex query()
 * @method static Builder|Hex whereCreatedAt($value)
 * @method static Builder|Hex whereElevation($value)
 * @method static Builder|Hex whereFeature($value)
 * @method static Builder|Hex whereId($value)
 * @method static Builder|Hex whereMapId($value)
 * @method static Builder|Hex whereSurface($value)
 * @method static Builder|Hex whereUpdatedAt($value)
 * @method static Builder|Hex whereX($value)
 * @method static Builder|Hex whereY($value)
 * @property-read Collection<int, Hex> $adjacent_hexes
 * @property-read string $name
 * @property-read int $move_cost
 * @property int $region_id
 * @property Domain $domain
 * @property ResourceType|null $resource
 * @property int|null $resource_amount
 * @property ImprovementType|null $improvement
 * @property int|null $improvement_health
 * @property mixed|null $knowledge
 * @property mixed|null $events
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Building> $buildings
 * @property-read int|null $buildings_count
 * @property-read City|null $city
 * @property-read Collection<int, YieldModifier|YieldModifiersFor> $yield_modifiers
 * @property-read Region $region
 * @method static Builder|Hex whereDomain($value)
 * @method static Builder|Hex whereEvents($value)
 * @method static Builder|Hex whereImprovement($value)
 * @method static Builder|Hex whereImprovementHealth($value)
 * @method static Builder|Hex whereKnowledge($value)
 * @method static Builder|Hex whereRegionId($value)
 * @method static Builder|Hex whereResource($value)
 * @method static Builder|Hex whereResourceAmount($value)
 * @mixin \Eloquent
 */
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

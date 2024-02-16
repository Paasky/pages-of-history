<?php

namespace App\Models;

use App\Casts\ImprovementCast;
use App\Casts\ResourceCast;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use App\Improvements\ImprovementType;
use App\Resources\ResourceType;
use Database\Factories\RegionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Region
 *
 * @property int $id
 * @property int $map_id
 * @property int $x
 * @property int $y
 * @property Domain $domain
 * @property Surface $surface
 * @property int $elevation
 * @property Feature|null $feature
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property ResourceType $resource
 * @property ImprovementType $improvement
 * @property-read Collection<int, Hex> $hexes
 * @property-read int|null $hexes_count
 * @property-read Map $map
 * @method static RegionFactory factory($count = null, $state = [])
 * @method static Builder|Region newModelQuery()
 * @method static Builder|Region newQuery()
 * @method static Builder|Region query()
 * @method static Builder|Region whereCreatedAt($value)
 * @method static Builder|Region whereDomain($value)
 * @method static Builder|Region whereElevation($value)
 * @method static Builder|Region whereFeature($value)
 * @method static Builder|Region whereId($value)
 * @method static Builder|Region whereMapId($value)
 * @method static Builder|Region whereSurface($value)
 * @method static Builder|Region whereUpdatedAt($value)
 * @method static Builder|Region whereX($value)
 * @method static Builder|Region whereY($value)
 * @mixin \Eloquent
 */
class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'map_id',
        'x',
        'y',
        'domain',
        'surface',
        'elevation',
        'feature',
    ];

    protected $casts = [
        'domain' => Domain::class,
        'surface' => Surface::class,
        'feature' => Feature::class,
        'resource' => ResourceCast::class,
        'improvement' => ImprovementCast::class,
    ];

    public function hexes(): HasMany
    {
        return $this->hasMany(Hex::class);
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }
}

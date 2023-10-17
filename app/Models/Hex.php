<?php

namespace App\Models;

use App\Coordinate;
use App\Enums\HexFeature;
use App\Enums\HexSurface;
use App\Managers\MapManager;
use Database\Factories\HexFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Hex
 *
 * @property int $id
 * @property int $map_id
 * @property int $x
 * @property int $y
 * @property HexSurface $surface
 * @property int $elevation
 * @property HexFeature|null $feature
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Coordinate $coordinate
 * @property-read Map $map
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
 * @mixin \Eloquent
 */
class Hex extends Model
{
    use HasFactory;

    protected $casts = [
        'surface' => HexSurface::class,
        'feature' => HexFeature::class,
    ];

    protected $fillable = [
        'map_id',
        'x',
        'y',
        'surface',
        'elevation',
        'feature',
    ];

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    public function getCoordinateAttribute(): Coordinate
    {
        return new Coordinate($this->x, $this->y);
    }

    public function adjacentHexes(int $distance = 1): Builder|static
    {
        return static::whereMapId($this->map_id)
            ->where(function (Builder $q) use ($distance) {
                $adjacentCoords = MapManager::adjacentCoordinates($this->coordinate, $this->map->size, $distance);
                foreach ($adjacentCoords as $coord) {
                    $q->orWhere($coord->toXYArray());
                }
            });
    }
}

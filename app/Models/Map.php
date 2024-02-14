<?php

namespace App\Models;

use App\Coordinate;
use Database\Factories\MapFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Map
 *
 * @property int $id
 * @property int $height
 * @property int $width
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Coordinate $size
 * @property-read Collection<int, Hex> $hexes
 * @property-read int|null $hexes_count
 * @property-read Collection<int, Unit> $units
 * @property-read int|null $units_count
 * @method static MapFactory factory($count = null, $state = [])
 * @method static Builder|Map newModelQuery()
 * @method static Builder|Map newQuery()
 * @method static Builder|Map query()
 * @method static Builder|Map whereCreatedAt($value)
 * @method static Builder|Map whereHeight($value)
 * @method static Builder|Map whereId($value)
 * @method static Builder|Map whereUpdatedAt($value)
 * @method static Builder|Map whereWidth($value)
 * @property-read Collection<int, Player> $players
 * @property-read int|null $players_count
 * @property-read string $name
 * @mixin Eloquent
 */
class Map extends Model
{
    use HasFactory;
    use PohModel;

    protected $fillable = [
        'height',
        'width',
    ];

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function getSizeAttribute(): Coordinate
    {
        return new Coordinate($this->width, $this->height);
    }
}

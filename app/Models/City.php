<?php

namespace App\Models;

use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\City
 *
 * @property int $id
 * @property int $hex_id
 * @property int $player_id
 * @property string $name
 * @property int $health
 * @property mixed|null $yield_stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Citizen> $citizens
 * @property-read int|null $citizens_count
 * @property-read Collection<int, YieldModifier|YieldModifiersFor> $yield_modifiers
 * @property-read Hex $hex
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Religion> $holyCityForReligions
 * @property-read int|null $holy_city_for_religions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Unit> $homeForUnits
 * @property-read int|null $home_for_units_count
 * @property-read Player $player
 * @method static CityFactory factory($count = null, $state = [])
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereHealth($value)
 * @method static Builder|City whereHexId($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City wherePlayerId($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @method static Builder|City whereYieldStock($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'hex_id',
        'player_id',
        'name',
        'health',
        'production_queue',
        'yield_stock',
    ];

    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class);
    }

    public function hex(): BelongsTo
    {
        return $this->belongsTo(Hex::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function holyCityForReligions(): HasMany
    {
        return $this->hasMany(Religion::class);
    }

    public function homeForUnits(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public function getYieldModifiersAttribute(): Collection
    {
        return $this->citizens->map(
            fn(Citizen $citizen) => $citizen->yield_modifiers
        )->flatten();
    }
}

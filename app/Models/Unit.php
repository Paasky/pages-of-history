<?php

namespace App\Models;

use App\Enums\Armor;
use App\Enums\UnitType;
use App\Enums\Weapon;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Database\Factories\UnitFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Unit
 *
 * @property int $id
 * @property int $hex_id
 * @property int $map_id
 * @property int $player_id
 * @property UnitType $type
 * @property int $health
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Hex $hex
 * @property-read Map $map
 * @property-read Player $player
 * @method static UnitFactory factory($count = null, $state = [])
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereCreatedAt($value)
 * @method static Builder|Unit whereHealth($value)
 * @method static Builder|Unit whereHexId($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit whereMapId($value)
 * @method static Builder|Unit wherePlayerId($value)
 * @method static Builder|Unit whereType($value)
 * @method static Builder|Unit whereUpdatedAt($value)
 * @property-read string $name
 * @property float $moves_remaining
 * @method static Builder|Unit whereMovesRemaining($value)
 * @method static Builder|Unit whereWeapon($value)
 * @property Weapon|null $weapon
 * @property Armor|null $armor
 * @property-read int $strength
 * @property Carbon|null $deleted_at
 * @method static Builder|Unit onlyTrashed()
 * @method static Builder|Unit whereArmor($value)
 * @method static Builder|Unit whereDeletedAt($value)
 * @method static Builder|Unit withTrashed()
 * @method static Builder|Unit withoutTrashed()
 * @property-read int $cost
 * @property-read int $ranged_strength
 * @mixin \Eloquent
 */
class Unit extends Model
{
    use HasFactory;
    use PohModel;
    use SoftDeletes;

    protected $fillable = [
        'hex_id',
        'player_id',
        'unit_design_id',
        'city_id',
        'type',
        'health',
        'moves_remaining',
    ];

    protected $casts = [
        'type' => UnitType::class,
    ];

    public function hex(): BelongsTo
    {
        return $this->belongsTo(Hex::class);
    }

    public function homeCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function unitDesign(): BelongsTo
    {
        return $this->belongsTo(UnitDesign::class);
    }

    /**
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public function getYieldModifiersAttribute(): Collection
    {
        return collect();
    }
}

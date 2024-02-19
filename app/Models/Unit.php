<?php

namespace App\Models;

use App\Enums\UnitType;
use App\GameConcept;
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
 * @property int $player_id
 * @property int $unit_design_id
 * @property int|null $city_id
 * @property UnitType $type
 * @property int $health
 * @property float $moves_remaining
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string $name
 * @property-read Collection<int, YieldModifier|YieldModifiersFor> $yield_modifiers
 * @property-read Hex $hex
 * @property-read City|null $homeCity
 * @property-read Player $player
 * @property-read UnitDesign $unitDesign
 * @method static UnitFactory factory($count = null, $state = [])
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit onlyTrashed()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereCityId($value)
 * @method static Builder|Unit whereCreatedAt($value)
 * @method static Builder|Unit whereDeletedAt($value)
 * @method static Builder|Unit whereHealth($value)
 * @method static Builder|Unit whereHexId($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit whereMovesRemaining($value)
 * @method static Builder|Unit wherePlayerId($value)
 * @method static Builder|Unit whereType($value)
 * @method static Builder|Unit whereUnitDesignId($value)
 * @method static Builder|Unit whereUpdatedAt($value)
 * @method static Builder|Unit withTrashed()
 * @method static Builder|Unit withoutTrashed()
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
    public function getYieldModifiersAttribute(Model|GameConcept $against = null, bool $combine = true): Collection
    {
        if (is_null($combine)) {
            $combine = true;
        }

        $modifiers = $this->player->global_yield_modifiers
            ->merge($this->unitDesign->yield_modifiers);

        return YieldModifier::getValidModifiers($modifiers, $this, $against, $combine);
    }
}

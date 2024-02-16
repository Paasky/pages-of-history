<?php

namespace App\Models;

use App\Casts\UnitArmorCast;
use App\Casts\UnitEquipmentCast;
use App\Casts\UnitPlatformCast;
use App\Enums\UnitType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Database\Factories\UnitDesignFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\UnitDesign
 *
 * @property int $id
 * @property int $player_id
 * @property string $name
 * @property UnitPlatformType $platform
 * @property UnitEquipmentType $equipment
 * @property UnitArmorType|null $armor
 * @property UnitType $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Player $player
 * @property-read Collection<int, Unit> $units
 * @property-read int|null $units_count
 * @method static UnitDesignFactory factory($count = null, $state = [])
 * @method static Builder|UnitDesign newModelQuery()
 * @method static Builder|UnitDesign newQuery()
 * @method static Builder|UnitDesign query()
 * @method static Builder|UnitDesign whereArmor($value)
 * @method static Builder|UnitDesign whereCreatedAt($value)
 * @method static Builder|UnitDesign whereEquipment($value)
 * @method static Builder|UnitDesign whereId($value)
 * @method static Builder|UnitDesign whereName($value)
 * @method static Builder|UnitDesign wherePlatform($value)
 * @method static Builder|UnitDesign wherePlayerId($value)
 * @method static Builder|UnitDesign whereType($value)
 * @method static Builder|UnitDesign whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UnitDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'name',
        'platform',
        'equipment',
        'armor',
        'type',
    ];

    protected $casts = [
        'platform' => UnitPlatformCast::class,
        'equipment' => UnitEquipmentCast::class,
        'armor' => UnitArmorCast::class,
        'type' => UnitType::class,
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}

<?php

namespace App\Models;

use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $map_id
 * @property int|null $religion_id
 * @property string $color1
 * @property string $color2
 * @property mixed|null $yield_stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, City> $cities
 * @property-read int|null $cities_count
 * @property-read Culture|null $culture
 * @property-read string $name
 * @property-read Collection<int, YieldModifier|YieldModifiersFor> $yield_modifiers
 * @property-read Map $map
 * @property-read Religion|null $religion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Technology> $technologies
 * @property-read int|null $technologies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, UnitDesign> $unitDesigns
 * @property-read int|null $unit_designs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Unit> $units
 * @property-read int|null $units_count
 * @property-read User|null $user
 * @method static PlayerFactory factory($count = null, $state = [])
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereColor1($value)
 * @method static Builder|Player whereColor2($value)
 * @method static Builder|Player whereCreatedAt($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereMapId($value)
 * @method static Builder|Player whereReligionId($value)
 * @method static Builder|Player whereUpdatedAt($value)
 * @method static Builder|Player whereUserId($value)
 * @method static Builder|Player whereYieldStock($value)
 * @mixin \Eloquent
 */
class Player extends Model
{
    use HasFactory;
    use PohModel;

    protected $fillable = [
        'map_id',
        'user_id',
        'religion_id',
        'color1',
        'color2',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function culture(): HasOne
    {
        return $this->hasOne(Culture::class);
    }

    /**
     * @return Attribute|Collection<string, TechnologyType>
     */
    public function knownTechnologyTypes(): Attribute|Collection
    {
        return Attribute::make(
            get: fn(): Collection => $this->technologies
                ->where('is_known', true)
                ->mapWithKeys(
                    fn(Technology $tech) => [$tech->type->slug() => $tech->type]
                )
        );
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function technologies(): HasMany
    {
        return $this->hasMany(Technology::class);
    }

    public function unitDesigns(): HasMany
    {
        return $this->hasMany(UnitDesign::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public function getYieldModifiersAttribute(): Collection
    {
        return $this->cities->map(fn(City $city) => $city->yield_modifiers)->flatten();
    }
}

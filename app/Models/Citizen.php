<?php

namespace App\Models;

use App\Enums\YieldType;
use App\GameConcept;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Database\Factories\CitizenFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Citizen
 *
 * @property int $id
 * @property int $city_id
 * @property int $culture_id
 * @property int|null $religion_id
 * @property string|null $workplace_type
 * @property int|null $workplace_id
 * @property YieldType $desire_yield
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read City|null $city
 * @property-read Culture|null $culture
 * @property-read Collection<int, YieldModifier|YieldModifiersFor> $yield_modifiers
 * @property-read Religion|null $religion
 * @property-read Hex|Building|null $workplace
 * @method static CitizenFactory factory($count = null, $state = [])
 * @method static Builder|Citizen newModelQuery()
 * @method static Builder|Citizen newQuery()
 * @method static Builder|Citizen query()
 * @method static Builder|Citizen whereCityId($value)
 * @method static Builder|Citizen whereCreatedAt($value)
 * @method static Builder|Citizen whereCultureId($value)
 * @method static Builder|Citizen whereDesireYield($value)
 * @method static Builder|Citizen whereId($value)
 * @method static Builder|Citizen whereReligionId($value)
 * @method static Builder|Citizen whereUpdatedAt($value)
 * @method static Builder|Citizen whereWorkplaceId($value)
 * @method static Builder|Citizen whereWorkplaceType($value)
 * @mixin \Eloquent
 */
class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'culture_id',
        'religion_id',
        'workplace_type',
        'workplace_id',
        'desire_yield',
    ];

    protected $casts = [
        'desire_yield' => YieldType::class,
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function culture(): BelongsTo
    {
        return $this->belongsTo(Culture::class);
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function workplace(): MorphTo|Hex|Building|null
    {
        return $this->morphTo();
    }

    /**
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public function getYieldModifiersAttribute(Model|GameConcept $towards = null, bool $combine = true): Collection
    {
        if (is_null($combine)) {
            $combine = true;
        }

        $yieldModifiers = collect([
            new YieldModifier($this, YieldType::Food, -2),
            new YieldModifier($this, YieldType::Health, -1),
        ]);

        // Exists
        $happinessYield = -1;

        // Doesn't work?
        if (!$this->workplace) {
            $happinessYield += -1;
        }

        // Works with desired yield?
        if ($this->workplace) {
            $happinessYield += $this->workplace->yield_modifiers
                ->filter(function (YieldModifier|YieldModifiersFor $modifier) {
                    if ($modifier instanceof YieldModifier) {
                        return $modifier->type === $this->desire_yield &&
                            ($modifier->amount > 0 || $modifier->percent) > 0;
                    }
                    foreach ($modifier->modifiers as $subModifier) {
                        if ($subModifier->type === $this->desire_yield &&
                            ($subModifier->amount > 0 || $subModifier->percent) > 0
                        ) {
                            return true;
                        }
                    }
                    return false;
                })
                ->isNotEmpty()
                ? 0
                : -0.5;
        }

        // City owner has same culture?
        if ($this->culture) {
            $happinessYield += $this->city->player->culture?->is($this->culture)
                ? 0
                : -0.5;
        }

        // City owner has same religion?
        if ($this->religion) {
            $happinessYield += $this->city->player->religion?->is($this->religion)
                ? 0
                : -0.5;
        }

        if ($happinessYield) {
            $yieldModifiers->push(new YieldModifier($this, YieldType::Happiness, $happinessYield));
        }

        // Gather all modifiers from the citizen's culture, religion, workplace & city owner's technologies
        $yieldModifiers = $yieldModifiers
            ->merge($this->culture?->yield_modifiers ?: [])
            ->merge($this->religion?->yield_modifiers ?: [])
            ->merge($this->workplace?->yield_modifiers ?: []);

        foreach ($this->city->player->known_technology_types as $technology) {
            $yieldModifiers = $yieldModifiers->merge($technology->yieldModifiers());
        }

        return YieldModifier::getValidModifiers($yieldModifiers, $this, $towards, $combine);
    }
}

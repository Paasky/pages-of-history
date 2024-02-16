<?php

namespace App\Models;

use App\Enums\YieldType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

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
    public function getYieldModifiersAttribute(): Collection
    {
        $yieldModifiers = collect();

        // Gather everything that makes a Citizen happy/unhappy
        $happiness = [
            // Has work
            (bool)$this->workplace,

            // Works with desired yield
            $this->workplace?->yieldModifiers()->filter(
                fn(YieldModifier|YieldModifiersFor $modifier) => $modifier->type === $this->desire_yield
            )->isNotEmpty(),

            // City owner has same culture
            $this->culture
                ? (bool)$this->city->player->culture?->is($this->culture)
                : null,

            // City owner has same religion
            $this->religion
                ? (bool)$this->city->player->religion?->is($this->religion)
                : null
        ];
        foreach ($happiness as $isHappy) {
            if ($isHappy === true) {
                $yieldModifiers[] = new YieldModifier(YieldType::Happiness, 1);
            }
            if ($isHappy === false) {
                $yieldModifiers[] = new YieldModifier(YieldType::Happiness, -1);
            }
        }

        // Gather all modifiers from the citizen's culture, religion, workplace & city owner's technologies
        $yieldModifiers = $yieldModifiers
            ->merge($this->culture?->yieldModifiers() ?: [])
            ->merge($this->religion?->yieldModifiers() ?: [])
            ->merge($this->workplace?->yieldModifiers() ?: []);
        foreach ($this->city->player->technologies as $technology) {
            $yieldModifiers = $yieldModifiers->merge($technology->type->yieldModifiers());
        }

        // Merge modifiers together: global modifiers + any that apply for the workplace (if there is one)
        return YieldModifier::mergeModifiers(
            $yieldModifiers,
            collect([$this->workplace])
        )->filter(
        // Only allow modifiers with a set amount - one citizen can't boost everyone else
            fn(YieldModifier $modifier) => (bool)$modifier->amount
        );
    }
}

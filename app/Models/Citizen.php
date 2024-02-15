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
        // todo
        // - has work: unhappy/happy
        // - works with desire yield: unhappy/happy
        // - city owner has same culture: unhappy/happy
        // - city owner has same religion: unhappy/happy
        // - each happy/unhappy +10%/-25% to all yields citizen is making (not as % yield modifiers)

        return collect()
            ->merge($this->culture?->yieldModifiers() ?: [])
            ->merge($this->religion?->yieldModifiers() ?: [])
            ->merge($this->workplace?->yieldModifiers() ?: []);
    }
}

<?php

namespace App\Models;

use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'hex_id',
        'player_id',
        'name',
        'health',
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

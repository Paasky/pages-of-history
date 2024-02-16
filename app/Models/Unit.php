<?php

namespace App\Models;

use App\Enums\UnitType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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

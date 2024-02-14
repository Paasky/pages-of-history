<?php

namespace App\Models;

use App\Casts\UnitArmorCast;
use App\Casts\UnitEquipmentCast;
use App\Casts\UnitPlatformCast;
use App\Enums\UnitType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

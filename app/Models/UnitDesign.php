<?php

namespace App\Models;

use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'name',
        'platform',
        'equipment',
        'armor',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function platform(): Attribute
    {
        return Attribute::make(
            get: fn(string $slug): UnitPlatformType => UnitPlatformType::fromSlug($slug),
        );
    }

    public function equipment(): Attribute
    {
        return Attribute::make(
            get: fn(string $slug): UnitEquipmentType => UnitEquipmentType::fromSlug($slug),
        );
    }

    public function armor(): Attribute
    {
        return Attribute::make(
            get: fn(?string $slug): ?UnitArmorType => $slug ? UnitArmorType::fromSlug($slug) : null,
        );
    }
}

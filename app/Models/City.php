<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}

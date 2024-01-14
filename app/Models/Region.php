<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 *
 * @property-read Collection>int, \App\Models\Citizen> $citizens
 */
class Region extends Model
{
    use HasFactory;

    public function citizens(): HasManyThrough
    {
        return $this->hasManyThrough(
            Citizen::class,
            Hex::class
        );
    }

    public function hexes(): HasMany
    {
        return $this->hasMany(Hex::class);
    }
}

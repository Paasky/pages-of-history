<?php

namespace App\Models;

use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 *
 * @property-read Collection>int, \App\Models\Citizen> $citizens
 */
class Region extends Model
{
    use HasFactory;

    protected $casts = [
        'domain' => Domain::class,
        'feature' => Feature::class,
        'surface' => Surface::class,
    ];

    protected $fillable = [
        'map_id',
        'x',
        'y',
        'surface',
        'elevation',
        'feature',
    ];

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

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }
}

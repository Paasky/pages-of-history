<?php

namespace App\Models;

use App\Casts\ImprovementCast;
use App\Casts\ResourceCast;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'map_id',
        'x',
        'y',
        'domain',
        'surface',
        'elevation',
        'feature',
    ];

    protected $casts = [
        'domain' => Domain::class,
        'surface' => Surface::class,
        'feature' => Feature::class,
        'resource' => ResourceCast::class,
        'improvement' => ImprovementCast::class,
    ];

    public function hexes(): HasMany
    {
        return $this->hasMany(Hex::class);
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }
}

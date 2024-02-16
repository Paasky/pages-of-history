<?php

namespace App\Models;

use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Player extends Model
{
    use HasFactory;
    use PohModel;

    protected $fillable = [
        'map_id',
        'user_id',
        'religion_id',
        'color1',
        'color2',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function culture(): HasOne
    {
        return $this->hasOne(Culture::class);
    }

    /**
     * @return Attribute|Collection<string, TechnologyType>
     */
    public function knownTechnologyTypes(): Attribute|Collection
    {
        return Attribute::make(
            get: fn(): Collection => $this->technologies
                ->where('is_known', true)
                ->mapWithKeys(
                    fn(Technology $tech) => [$tech->type->slug() => $tech->type]
                )
        );
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function technologies(): HasMany
    {
        return $this->hasMany(Technology::class);
    }

    public function unitDesigns(): HasMany
    {
        return $this->hasMany(UnitDesign::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public function getYieldModifiersAttribute(): Collection
    {
        return $this->cities->map(fn(City $city) => $city->yield_modifiers)->flatten();
    }
}

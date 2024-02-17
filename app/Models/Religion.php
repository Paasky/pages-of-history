<?php

namespace App\Models;

use App\Enums\ReligionTenet;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Database\Factories\ReligionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Religion
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @property Collection|ReligionTenet[] $tenets
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Citizen> $citizens
 * @property-read int|null $citizens_count
 * @property-read Collection|YieldModifier[]|YieldModifiersFor[] $yield_modifiers
 * @property-read City|null $holyCity
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Player> $players
 * @property-read int|null $players_count
 * @method static ReligionFactory factory($count = null, $state = [])
 * @method static Builder|Religion newModelQuery()
 * @method static Builder|Religion newQuery()
 * @method static Builder|Religion query()
 * @method static Builder|Religion whereCityId($value)
 * @method static Builder|Religion whereCreatedAt($value)
 * @method static Builder|Religion whereId($value)
 * @method static Builder|Religion whereName($value)
 * @method static Builder|Religion whereTenets($value)
 * @method static Builder|Religion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Religion extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'name',
        'tenets',
    ];

    protected $casts = [
        'tenets' => AsEnumCollection::class . ':' . ReligionTenet::class,
    ];

    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class);
    }

    public function holyCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function getYieldModifiersAttribute(): Collection
    {
        return $this->tenets?->map(
            fn(ReligionTenet $trait) => $trait->yieldModifiers()
        )->flatten() ?: collect();
    }
}

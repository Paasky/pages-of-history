<?php

namespace App\Models;

use Database\Factories\ReligionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Religion
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static ReligionFactory factory($count = null, $state = [])
 * @method static Builder|Religion newModelQuery()
 * @method static Builder|Religion newQuery()
 * @method static Builder|Religion query()
 * @method static Builder|Religion whereCreatedAt($value)
 * @method static Builder|Religion whereId($value)
 * @method static Builder|Religion whereUpdatedAt($value)
 * @property int $city_id
 * @property string $name
 * @property mixed|null $traits
 * @property mixed|null $virtues
 * @property mixed|null $vices
 * @property-read Collection<int, Citizen> $citizens
 * @property-read int|null $citizens_count
 * @property-read City|null $holyCity
 * @property-read Collection<int, Player> $players
 * @property-read int|null $players_count
 * @method static Builder|Religion whereCityId($value)
 * @method static Builder|Religion whereName($value)
 * @method static Builder|Religion whereTraits($value)
 * @method static Builder|Religion whereVices($value)
 * @method static Builder|Religion whereVirtues($value)
 * @mixin \Eloquent
 */
class Religion extends Model
{
    use HasFactory;

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
}

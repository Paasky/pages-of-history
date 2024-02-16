<?php

namespace App\Models;

use Database\Factories\CultureFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Culture
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static CultureFactory factory($count = null, $state = [])
 * @method static Builder|Culture newModelQuery()
 * @method static Builder|Culture newQuery()
 * @method static Builder|Culture query()
 * @method static Builder|Culture whereCreatedAt($value)
 * @method static Builder|Culture whereId($value)
 * @method static Builder|Culture whereUpdatedAt($value)
 * @property int $player_id
 * @property string $name
 * @property mixed|null $traits
 * @property mixed|null $vices
 * @property mixed|null $virtues
 * @property-read Collection<int, Citizen> $citizens
 * @property-read int|null $citizens_count
 * @property-read Player $player
 * @method static Builder|Culture whereName($value)
 * @method static Builder|Culture wherePlayerId($value)
 * @method static Builder|Culture whereTraits($value)
 * @method static Builder|Culture whereVices($value)
 * @method static Builder|Culture whereVirtues($value)
 * @mixin \Eloquent
 */
class Culture extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'name',
        'traits',
        'vices',
        'virtues',
    ];

    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

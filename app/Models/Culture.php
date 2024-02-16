<?php

namespace App\Models;

use App\Enums\CultureTrait;
use App\Enums\CultureVice;
use App\Enums\CultureVirtue;
use Database\Factories\CultureFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Culture
 *
 * @property int $id
 * @property int $player_id
 * @property string $name
 * @property Collection|CultureTrait[]|null $traits
 * @property Collection|CultureVice[]|null $vices
 * @property Collection|CultureVirtue[]|null $virtues
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Citizen> $citizens
 * @property-read int|null $citizens_count
 * @property-read Collection $yield_modifiers
 * @property-read Player $player
 * @method static CultureFactory factory($count = null, $state = [])
 * @method static Builder|Culture newModelQuery()
 * @method static Builder|Culture newQuery()
 * @method static Builder|Culture query()
 * @method static Builder|Culture whereCreatedAt($value)
 * @method static Builder|Culture whereId($value)
 * @method static Builder|Culture whereName($value)
 * @method static Builder|Culture wherePlayerId($value)
 * @method static Builder|Culture whereTraits($value)
 * @method static Builder|Culture whereUpdatedAt($value)
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

    protected $casts = [
        'traits' => AsEnumCollection::class . ':' . CultureTrait::class,
        'vices' => AsEnumCollection::class . ':' . CultureVice::class,
        'virtues' => AsEnumCollection::class . ':' . CultureVirtue::class,
    ];

    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function getYieldModifiersAttribute(): Collection
    {
        return collect()
            ->merge($this->traits?->map(
                fn(CultureTrait $trait) => $trait->yieldModifiers()
            ) ?: [])
            ->merge($this->vices?->map(
                fn(CultureVice $trait) => $trait->yieldModifiers()
            ) ?: [])
            ->merge($this->virtues?->map(
                fn(CultureVirtue $trait) => $trait->yieldModifiers()
            ) ?: [])
            ->flatten();
    }
}

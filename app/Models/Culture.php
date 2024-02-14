<?php

namespace App\Models;

use Database\Factories\CultureFactory;
use Illuminate\Database\Eloquent\Builder;
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

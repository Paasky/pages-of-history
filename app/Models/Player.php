<?php

namespace App\Models;

use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property int $map_id
 * @property int|null $user_id
 * @property string $color1
 * @property string $color2
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Map $map
 * @property-read User|null $user
 * @property-read Collection<int, Unit> $units
 * @property-read int|null $units_count
 * @method static PlayerFactory factory($count = null, $state = [])
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereColor1($value)
 * @method static Builder|Player whereColor2($value)
 * @method static Builder|Player whereCreatedAt($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereMapId($value)
 * @method static Builder|Player whereUpdatedAt($value)
 * @method static Builder|Player whereUserId($value)
 * @mixin \Eloquent
 */
class Player extends Model
{
    use HasFactory;
    use PohModel;

    protected $fillable = [
        'map_id',
        'user_id',
        'color1',
        'color2',
    ];

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

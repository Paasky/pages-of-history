<?php

namespace App\Models;

use App\Casts\TechnologyCast;
use App\Technologies\TechnologyType;
use Database\Factories\TechnologyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Technology
 *
 * @property int $id
 * @property int $player_id
 * @property TechnologyType|null $type
 * @property int $research
 * @property bool $is_known
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Player $player
 * @method static TechnologyFactory factory($count = null, $state = [])
 * @method static Builder|Technology newModelQuery()
 * @method static Builder|Technology newQuery()
 * @method static Builder|Technology query()
 * @method static Builder|Technology whereCreatedAt($value)
 * @method static Builder|Technology whereId($value)
 * @method static Builder|Technology whereIsKnown($value)
 * @method static Builder|Technology wherePlayerId($value)
 * @method static Builder|Technology whereResearch($value)
 * @method static Builder|Technology whereType($value)
 * @method static Builder|Technology whereUpdatedAt($value)
 * @property-read Collection $yield_modifiers
 * @mixin \Eloquent
 */
class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'type',
        'research',
        'is_known',
    ];

    protected $casts = [
        'type' => TechnologyCast::class,
        'is_known' => 'boolean',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function getYieldModifiersAttribute(): Collection
    {
        return $this->type->yieldModifiers();
    }
}

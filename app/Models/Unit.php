<?php

namespace App\Models;

use App\Enums\UnitType;
use Database\Factories\UnitFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Unit
 *
 * @property int $id
 * @property int $hex_id
 * @property int $map_id
 * @property int $player_id
 * @property UnitType $type
 * @property int $health
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Hex $hex
 * @property-read Map $map
 * @property-read Player $player
 * @method static UnitFactory factory($count = null, $state = [])
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereCreatedAt($value)
 * @method static Builder|Unit whereHealth($value)
 * @method static Builder|Unit whereHexId($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit whereMapId($value)
 * @method static Builder|Unit wherePlayerId($value)
 * @method static Builder|Unit whereType($value)
 * @method static Builder|Unit whereUpdatedAt($value)
 * @property-read string $name
 * @mixin \Eloquent
 */
class Unit extends Model
{
    use HasFactory;
    use PohModel;

    protected $fillable = [
        'hex_id',
        'map_id',
        'user_id',
        'type',
        'health',
    ];

    protected $casts = [
        'type' => UnitType::class,
    ];

    public function hex(): BelongsTo
    {
        return $this->belongsTo(Hex::class);
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
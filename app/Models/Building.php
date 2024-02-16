<?php

namespace App\Models;

use App\Buildings\BuildingType;
use Database\Factories\BuildingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Building
 *
 * @property int $id
 * @property int $hex_id
 * @property BuildingType $type
 * @property int $health
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Hex|null $hex
 * @method static BuildingFactory factory($count = null, $state = [])
 * @method static Builder|Building newModelQuery()
 * @method static Builder|Building newQuery()
 * @method static Builder|Building query()
 * @method static Builder|Building whereCreatedAt($value)
 * @method static Builder|Building whereHealth($value)
 * @method static Builder|Building whereHexId($value)
 * @method static Builder|Building whereId($value)
 * @method static Builder|Building whereType($value)
 * @method static Builder|Building whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'hex_id',
        'type',
        'health',
    ];

    protected $casts = [
        'type' => BuildingType::class,
    ];

    public function hex(): BelongsTo
    {
        return $this->belongsTo(Hex::class);
    }
}

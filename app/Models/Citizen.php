<?php

namespace App\Models;

use Database\Factories\CitizenFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Citizen
 *
 * @property int $id
 * @property int $culture_id
 * @property int $religion_id
 * @property string|null $workplace_type
 * @property int|null $workplace_id
 * @property string $desire
 * @property string $satisfaction
 * @property int|null $riot_turns_left
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static CitizenFactory factory($count = null, $state = [])
 * @method static Builder|Citizen newModelQuery()
 * @method static Builder|Citizen newQuery()
 * @method static Builder|Citizen query()
 * @method static Builder|Citizen whereCreatedAt($value)
 * @method static Builder|Citizen whereCultureId($value)
 * @method static Builder|Citizen whereDesire($value)
 * @method static Builder|Citizen whereId($value)
 * @method static Builder|Citizen whereReligionId($value)
 * @method static Builder|Citizen whereRiotTurnsLeft($value)
 * @method static Builder|Citizen whereSatisfaction($value)
 * @method static Builder|Citizen whereUpdatedAt($value)
 * @method static Builder|Citizen whereWorkplaceId($value)
 * @method static Builder|Citizen whereWorkplaceType($value)
 * @property-read Culture|null $culture
 * @property-read Religion|null $religion
 * @property-read Model|\Eloquent|Hex $workplace
 * @mixin \Eloquent
 */
class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'culture_id',
        'religion_id',
        'workplace_type',
        'workplace_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function culture(): BelongsTo
    {
        return $this->belongsTo(Culture::class);
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function workplace(): MorphTo|Hex
    {
        return $this->morphTo();
    }
}

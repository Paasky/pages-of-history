<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CitizenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen query()
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereCultureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereDesire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereReligionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereRiotTurnsLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereSatisfaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereWorkplaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Citizen whereWorkplaceType($value)
 * @property-read \App\Models\Culture|null $culture
 * @property-read \App\Models\Religion|null $religion
 * @property-read Model|\Eloquent|Hex $workplace
 * @mixin \Eloquent
 */
class Citizen extends Model
{
    use HasFactory;

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

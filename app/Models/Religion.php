<?php

namespace App\Models;

use App\Religion\ReligionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * App\Models\Religion
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ReligionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Religion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Religion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Religion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Religion extends Model
{
    use HasFactory;

    public function holyCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return Collection<int, ReligionTrait>
     */
    public function getTraitsProperty(): Collection
    {
        return collect($this->attributes['traits'] ?? [])->map(fn(string $trait) => ReligionTrait::from($trait));
    }

    /**
     * @param Collection<int, ReligionTrait> $traits
     */
    public function setTraitsProperty(Collection $traits): void
    {
        $this->attributes['traits'] = $traits->map(fn(ReligionTrait $trait) => $trait->value)->toArray();
    }
}

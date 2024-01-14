<?php

namespace App\Models;

use App\Culture\Traits\CultureTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * App\Models\Culture
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CultureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Culture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Culture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Culture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Culture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Culture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Culture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Culture extends Model
{
    use HasFactory;

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * @return Collection<int, CultureTrait>
     */
    public function getTraitsProperty(): Collection
    {
        return collect($this->attributes['traits'] ?? [])->map(fn(string $trait) => CultureTrait::from($trait));
    }

    /**
     * @param Collection<int, CultureTrait> $traits
     */
    public function setTraitsProperty(Collection $traits): void
    {
        $this->attributes['traits'] = $traits->map(fn(CultureTrait $trait) => $trait->value)->toArray();
    }
}

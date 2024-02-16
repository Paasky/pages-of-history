<?php

namespace App\Models;

use App\Enums\CultureTrait;
use App\Enums\CultureVice;
use App\Enums\CultureVirtue;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}

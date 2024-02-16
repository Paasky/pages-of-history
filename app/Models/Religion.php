<?php

namespace App\Models;

use App\Enums\ReligionTenet;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Religion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tenets',
    ];

    protected $casts = [
        'tenets' => AsEnumCollection::class . ':' . ReligionTenet::class,
    ];

    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class);
    }

    public function holyCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}

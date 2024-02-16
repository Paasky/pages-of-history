<?php

namespace App\Models;

use App\Coordinate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Map extends Model
{
    use HasFactory;
    use PohModel;

    protected $fillable = [
        'height',
        'width',
    ];

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function getSizeAttribute(): Coordinate
    {
        return new Coordinate($this->width, $this->height);
    }
}

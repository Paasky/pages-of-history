<?php

namespace App\Models;

use App\Technologies\TechnologyType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'is_known' => 'boolean',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function platform(): Attribute
    {
        return Attribute::make(
            get: fn(string $slug): TechnologyType => TechnologyType::fromSlug($slug),
        );
    }
}

<?php

namespace App\Models;

use App\Casts\TechnologyCast;
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
        'type' => TechnologyCast::class,
        'is_known' => 'boolean',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

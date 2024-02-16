<?php

namespace App\Models;

use App\Buildings\BuildingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

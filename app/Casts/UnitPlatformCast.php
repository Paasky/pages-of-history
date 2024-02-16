<?php

namespace App\Casts;

use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UnitPlatformCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?UnitPlatformType
    {
        return $value ? UnitPlatformType::fromSlug($value) : null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        /** @var UnitPlatformType|null $value */
        return $value?->slug();
    }
}

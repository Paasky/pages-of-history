<?php

namespace App\Casts;

use App\Buildings\BuildingType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class BuildingCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?BuildingType
    {
        return $value ? BuildingType::fromSlug($value) : null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        /** @var BuildingType|null $value */
        return $value?->slug();
    }
}

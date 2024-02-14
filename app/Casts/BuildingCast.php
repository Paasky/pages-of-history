<?php

namespace App\Casts;

use App\Buildings\BuildingType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class BuildingCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): BuildingType
    {
        return BuildingType::fromSlug($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var BuildingType $value */
        return $value->slug();
    }
}

<?php

namespace App\Casts;

use App\Improvements\ImprovementType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ImprovementCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ImprovementType
    {
        return ImprovementType::fromSlug($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var ImprovementType $value */
        return $value->slug();
    }
}

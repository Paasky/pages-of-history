<?php

namespace App\Casts;

use App\Technologies\TechnologyType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TechnologyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): TechnologyType
    {
        return TechnologyType::fromSlug($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var TechnologyType $value */
        return $value->slug();
    }
}

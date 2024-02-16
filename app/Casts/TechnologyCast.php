<?php

namespace App\Casts;

use App\Technologies\TechnologyType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TechnologyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?TechnologyType
    {
        return $value ? TechnologyType::fromSlug($value) : null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        /** @var TechnologyType|null $value */
        return $value?->slug();
    }
}

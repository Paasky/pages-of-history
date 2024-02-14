<?php

namespace App\Casts;

use App\Resources\ResourceType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ResourceCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ResourceType
    {
        return ResourceType::fromSlug($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var ResourceType $value */
        return $value->slug();
    }
}

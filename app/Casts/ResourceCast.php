<?php

namespace App\Casts;

use App\Resources\ResourceType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ResourceCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?ResourceType
    {
        return $value ? ResourceType::fromSlug($value) : null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        /** @var ResourceType|null $value */
        return $value?->slug();
    }
}

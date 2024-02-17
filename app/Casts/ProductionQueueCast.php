<?php

namespace App\Casts;

use App\Map\ProductionQueue;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProductionQueueCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ProductionQueue
    {
        return new ProductionQueue(is_string($value) ? json_decode($value, true) : $value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var ProductionQueue $value */
        return json_encode($value->toArray());
    }
}

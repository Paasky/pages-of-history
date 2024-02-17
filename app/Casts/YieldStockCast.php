<?php

namespace App\Casts;

use App\Yields\YieldStock;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class YieldStockCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): YieldStock
    {
        return new YieldStock(is_string($value) ? json_decode($value, true) : $value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var YieldStock $value */
        return $value->getStock()->toJson();
    }
}

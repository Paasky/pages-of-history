<?php

namespace App\Casts;

use App\Map\HexEvent;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class HexEventsCast implements CastsAttributes
{
    /** @return Collection<HexEvent> */
    public function get(Model $model, string $key, mixed $value, array $attributes): Collection
    {
        return collect(is_string($value) ? json_decode($value, true) : $value)
            ->map(fn(array $event) => HexEvent::fromArray($event));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var Collection|array|null $value */
        return is_array($value) ? json_encode($value) : ($value?->toJson() ?: '[]');
    }
}

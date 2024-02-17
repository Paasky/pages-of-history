<?php

namespace App\Casts;

use App\Map\HexKnowledge;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class HexKnowledgeCast implements CastsAttributes
{
    /** @return Collection<HexKnowledge()> */
    public function get(Model $model, string $key, mixed $value, array $attributes): Collection
    {
        return collect(is_string($value) ? json_decode($value, true) : $value)
            ->map(fn(array $knowledge) => HexKnowledge::fromArray($knowledge));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var Collection $value */
        return $value->toJson();
    }
}

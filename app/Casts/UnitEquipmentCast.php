<?php

namespace App\Casts;

use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UnitEquipmentCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?UnitEquipmentType
    {
        return $value ? UnitEquipmentType::fromSlug($value) : null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        /** @var UnitEquipmentType|null $value */
        return $value?->slug();
    }
}

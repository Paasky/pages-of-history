<?php

namespace App\Casts;

use App\UnitArmor\UnitArmorType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UnitArmorCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): UnitArmorType
    {
        return UnitArmorType::fromSlug($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var UnitArmorType $value */
        return $value->slug();
    }
}

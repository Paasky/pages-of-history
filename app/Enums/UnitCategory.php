<?php

namespace App\Enums;

enum UnitCategory: string
{
    use PohEnum;

    case Civilian = 'Civilian';
    case Combat = 'Combat';
    case Support = 'Support';

    /**
     * @return UnitType[]
     * @throws \Exception
     */
    public function unitTypes(): array
    {
        return array_filter(UnitType::cases(), fn(UnitType $unitType) => $this->is($unitType->category()));
    }
}

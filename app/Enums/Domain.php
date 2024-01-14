<?php

namespace App\Enums;

enum Domain: string
{
    use PohEnum;

    case Air = 'Air';
    case Land = 'Land';
    case Water = 'Water';

    /**
     * @return UnitType[]
     * @throws \Exception
     */
    public function unitTypes(): array
    {
        return array_filter(UnitType::cases(), fn(UnitType $unitType) => $this->is($unitType->domain()));
    }
}

<?php

namespace App\Enums;

enum Domain: string
{
    use PohEnum;

    case Air = 'Air';
    case Land = 'Land';
    case Water = 'Water';

    public function cssBackground(): string
    {
        return match ($this) {
            self::Air => "url('/tiles/air.jpg')",
            self::Land => "url('/tiles/land.jpg')",
            self::Water => "url('/tiles/water.jpg')",
        };
    }

    public static function elevationCssBackground(int $elevation): ?string
    {
        return match (true) {
            $elevation >= 5 => "url('/tiles/mountain.jpg')",
            $elevation >= 1 => "url('/tiles/hills.jpg')",
            default => null,
        };
    }

    /**
     * @return UnitType[]
     * @throws \Exception
     */
    public function unitTypes(): array
    {
        return array_filter(UnitType::cases(), fn(UnitType $unitType) => $this->is($unitType->domain()));
    }
}

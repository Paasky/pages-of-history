<?php

namespace App\Enums;

enum ArmorType: string
{
    use PohEnum;

    case Human = 'Human';
    case Vehicle = 'Vehicle';
    case Air = 'Air';
    case Camouflage = 'Camouflage';
    case Stealth = 'Stealth';

    /**
     * @return Armor[]
     */
    public function armors(): array
    {
        return array_filter(
            Armor::cases(),
            fn(Armor $armor) => $this->is($armor->type())
        );
    }
}

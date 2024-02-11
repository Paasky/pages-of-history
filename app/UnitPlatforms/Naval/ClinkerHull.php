<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\HighMedieval\Compass;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Multideck;
use App\UnitEquipment\Cannon\Bombard;
use App\UnitEquipment\Diplomacy\Emissary;
use App\UnitEquipment\Diplomacy\Envoy;
use App\UnitEquipment\Espionage\Courtesan;
use App\UnitEquipment\Expansion\Settler;
use App\UnitEquipment\Exploring\Scout;
use App\UnitEquipment\NavalAssault\RaidingParty;
use App\UnitEquipment\NavalAssault\SteelRam;
use App\UnitEquipment\Siege\Onager;
use App\UnitEquipment\Siege\Trebuchet;
use App\UnitEquipment\Trade\Merchant;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class ClinkerHull extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;
    public int $moves = 4;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),
            Multideck::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            SteelRam::get(),
            RaidingParty::get(),

            Onager::get(),
            Trebuchet::get(),
            Bombard::get(),

            Settler::get(),
            Merchant::get(),
            Emissary::get(),
            Envoy::get(),
            Courtesan::get(),
            Scout::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Naval;
    }

    public function icon(): string
    {
        return 'fa-sailboat';
    }

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect([UnitCapability::CanTravelOnSea]);
    }

    public function technology(): ?TechnologyType
    {
        return Compass::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return CarvelHull::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Cost, percent: 30),
            new YieldModifier(YieldType::Moves, 4),
        ]);
    }
}

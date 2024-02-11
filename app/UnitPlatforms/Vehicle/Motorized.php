<?php

namespace App\UnitPlatforms\Vehicle;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Gilded\Combustion;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Person\BodyArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AntiAir\AiMissile;
use App\UnitEquipment\AntiAir\AntiAirGun;
use App\UnitEquipment\AntiAir\GuidedMissile;
use App\UnitEquipment\AntiAir\HomingMissile;
use App\UnitEquipment\Artillery\Artillery;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Expansion\Pioneer;
use App\UnitEquipment\Exploring\Archeologist;
use App\UnitEquipment\Firearm\AssaultRifle;
use App\UnitEquipment\Firearm\LaserRifle;
use App\UnitEquipment\Firearm\RepeatingRifle;
use App\UnitEquipment\Firearm\ScopeRifle;
use App\UnitEquipment\RocketArtillery\RocketArtillery;
use App\UnitEquipment\SkirmishFirearm\AiGuidedMortar;
use App\UnitEquipment\SkirmishFirearm\MachineGun;
use App\UnitEquipment\SkirmishFirearm\Mortar;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\Trade\ContainerHold;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Motorized extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),
            BodyArmor::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Pioneer::get(),

            Spy::get(),
            Diplomat::get(),
            Archeologist::get(),

            CargoHold::get(),
            ContainerHold::get(),

            RepeatingRifle::get(),
            AssaultRifle::get(),
            ScopeRifle::get(),
            LaserRifle::get(),

            MachineGun::get(),
            Mortar::get(),
            AiGuidedMortar::get(),

            Artillery::get(),
            Howitzer::get(),
            RocketArtillery::get(),

            AntiAirGun::get(),
            HomingMissile::get(),
            GuidedMissile::get(),
            AiMissile::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Vehicle;
    }

    public function icon(): string
    {
        return 'fa-truck';
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect([Oil::get()]);
    }

    public function technology(): ?TechnologyType
    {
        return Combustion::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Cost, percent: 50),
            new YieldModifier(YieldType::Moves, 3),
        ]);
    }
}

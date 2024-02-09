<?php

namespace App\UnitPlatforms;

use App\AbstractType;
use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\TechnologyEra;
use App\Enums\UnitArmorCategory;
use App\Enums\UnitCapability;
use App\Enums\UnitEquipmentCategory;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\GameConcept;
use App\Resources\ResourceType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Multideck;
use App\UnitEquipment\UnitEquipmentType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

abstract class UnitPlatformType extends AbstractType
{
    public int $equipmentSlots = 0;
    public int $armorSlots = 0;
    public int $maxWeight = 0;
    public int $moves = 2;
    public int $range = 0;
    public int $maneuvering = 0;

    /** @return Collection<int, UnitArmorType> */
    abstract public function armors(): Collection;

    abstract public function category(): UnitPlatformCategory;

    public function canHave(UnitEquipmentType $equipment, UnitArmorType $armor = null): bool
    {
        // I can't have this equipment
        if (!$this->equipment()->contains($equipment)) {
            return false;
        }
        // WMD can't be used like regular equipment
        if ($equipment->category() === UnitEquipmentCategory::MassDestruction) {
            return false;
        }

        $weightLeft = $this->maxWeight;
        $equipmentLeft = $this->equipmentSlots;
        $armorLeft = $this->armorSlots;

        // Test Equipment fits in the Platform
        $weightLeft -= $equipment->weight;
        $equipmentLeft -= $equipment->weight;
        if ($weightLeft < 0 || $equipmentLeft < 0) {
            return false;
        }

        // No Armor means... no armor
        $armor = $armor === NoArmor::get() ? null : $armor;
        if (!$armor) {
            return true;
        }

        // Test Equipment can have any armor
        if (!$equipment->canHaveArmor()) {
            return false;
        }

        // I can't have this armor
        if (!$this->armors()->contains($armor)) {
            return false;
        }

        // Test Armor fits in the Platform
        $weightLeft -= $armor->weight;
        $armorLeft -= $armor->weight;
        if ($weightLeft < 0 || $armorLeft < 0) {
            return false;
        }

        // Multideck can be used in any era
        if ($armor === Multideck::get()) {
            return true;
        }

        // Check era aren't incompatible only if both can be upgraded
        $equipmentEra = $equipment->technology()?->era()->order() ?: 1;
        $armorEra = $armor->technology()?->era()->order() ?: 1;
        if (abs($equipmentEra - $armorEra) > 1) {
            return false;
        }

        // Final special cases for Stealth:
        if ($armor->category() === UnitArmorCategory::Stealth &&
            $equipment->category()->is(UnitEquipmentCategory::FlightDeck, UnitEquipmentCategory::EnergyWeapon)
        ) {
            return false;
        }

        return true;
    }

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect([$this->building(), $this->technology(), ...$this->resources()])->filter();
    }

    public function building(): BuildingType|BuildingCategory|null
    {
        return null;
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect();
    }

    /**
     * @return Collection<int, UnitPlatformType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('UnitPlatforms'),
            [UnitPlatformType::class]
        );
    }

    /** @return Collection<int, UnitEquipmentType> */
    abstract public function equipment(): Collection;

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(
                YieldType::Cost,
                $this->technology()?->era()->baseCost() ?: TechnologyEra::BASE_COST
            )
        ]);
    }
}

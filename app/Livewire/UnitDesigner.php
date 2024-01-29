<?php

namespace App\Livewire;

use App\Enums\UnitPlatformCategory;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;
use Livewire\Component;

class UnitDesigner extends Component
{
    public bool $show = false;
    public ?string $platformSlug = null;
    public ?string $equipmentSlug = null;
    public ?string $armorSlug = null;

    public function setPlatform(?string $slug): void
    {
        $this->platformSlug = $slug;
        $this->equipmentSlug = null;
        $this->armorSlug = null;
    }

    public function setEquipment(?string $slug): void
    {
        $this->equipmentSlug = $slug;
        $this->armorSlug = null;
    }

    public function setArmor(?string $slug): void
    {
        $this->armorSlug = $slug;
    }

    public function render()
    {
        $platform = $this->platformSlug ? UnitPlatformType::fromSlug($this->platformSlug) : null;
        $equipment = $this->equipmentSlug ? UnitEquipmentType::fromSlug($this->equipmentSlug) : null;
        $armor = $this->armorSlug ? UnitArmorType::fromSlug($this->armorSlug) : null;
        $knownTechs = TechnologyType::all()
            ->filter(fn(TechnologyType $tech) => $tech->xy()->x < 24)
            ->keyBy(fn(TechnologyType $tech) => $tech->slug());

        $weightRemaining = $platform?->maxWeight
            - $equipment?->weight
            - $armor?->weight;
        $equipmentRemaining = $platform?->equipmentSlots - $equipment?->weight;
        $armorRemaining = $platform?->armorSlots - $armor?->weight;

        $platformItems = collect();
        foreach (UnitPlatformCategory::cases() as $category) {
            foreach ($category->items() as $platformItem) {
                $this->setUnitComponentToItems(
                    $platformItems,
                    $platformItem,
                    0,
                    0,
                    $knownTechs
                );
            }
        }
        $platformTitle = $platform
            ? 'Platform'
            : 'Select Platform';

        $equipmentItems = collect();
        if ($platform && !$equipment) {
            foreach ($platform->equipment() ?: [] as $equipmentItem) {
                $this->setUnitComponentToItems(
                    $equipmentItems,
                    $equipmentItem,
                    $weightRemaining,
                    $equipmentRemaining,
                    $knownTechs
                );
            }
        }
        $equipmentTitle = match (true) {
            !$platform => 'To select equipment, select the Platform first',
            !$equipment => 'Select Equipment',
            default => 'Equipment',
        };

        $armorItems = collect();
        if ($platform && $equipment?->canHaveArmor() && !$armor) {
            foreach ($platform->armors() ?: [] as $armorItem) {
                $this->setUnitComponentToItems(
                    $armorItems,
                    $armorItem,
                    $weightRemaining,
                    $armorRemaining,
                    $knownTechs
                );
            }
        }

        $armorTitle = match (true) {
            !$platform => 'To select Armor, select the Platform first',
            $platform->armors()->isEmpty() => 'This Platform cannot have Armor',
            !$equipment => 'To select Armor, select the Equipment first',
            !$equipment->canHaveArmor() => 'This Equipment cannot have Armor',
            !$armor => 'Select Armor',
            default => 'Armor',
        };

        return view('livewire.unit-designer', [
            'platform' => $platform,
            'platformTitle' => $platformTitle,
            'platformItems' => $platformItems,
            'equipment' => $equipment,
            'equipmentTitle' => $equipmentTitle,
            'equipmentItems' => $equipmentItems,
            'armor' => $armor,
            'armorTitle' => $armorTitle,
            'armorItems' => $armorItems,
        ]);
    }

    protected function setUnitComponentToItems(
        Collection                                       $items,
        UnitArmorType|UnitEquipmentType|UnitPlatformType $component,
        int                                              $weightRemaining,
        int                                              $slotsRemaining,
        Collection                                       $knownTechs
    ): void
    {
        $techSlug = $component->technology()?->slug();
        $upgradesToTechSlug = $component->upgradesTo()?->technology()?->slug();
        if (
            ($component->weight && $weightRemaining < $component->weight) ||
            ($component->weight && $slotsRemaining < $component->weight) ||
            ($techSlug && !isset($knownTechs[$techSlug])) ||
            ($upgradesToTechSlug && isset($knownTechs[$upgradesToTechSlug]))
        ) {
            return;
        }

        $categoryData = $items[$component->category()->slug()] ?? [
            'category' => $component->category(),
            'items' => collect(),
        ];

        $categoryData['items']->push($component);

        $items[$component->category()->slug()] = $categoryData;
    }
}

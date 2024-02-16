<?php

namespace App\Livewire;

use App\Enums\UnitEquipmentCategory;
use App\Models\Map;
use App\Models\Player;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitName;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UnitDesigner extends Component
{
    public bool $show = false;
    public ?string $platformSlug = null;
    public ?string $equipmentSlug = null;
    public ?string $armorSlug = null;
    public ?string $name = null;
    public ?string $namePlaceholder = null;

    protected Player $player;
    protected Collection $knownTechs;

    protected ?UnitPlatformType $platform = null;
    protected ?UnitEquipmentType $equipment = null;
    protected ?UnitArmorType $armor = null;

    public static function isValid(
        ?UnitPlatformType  $platform,
        ?UnitEquipmentType $equipment,
        ?UnitArmorType     $armor,
        Collection         $knownTechs
    ): bool
    {
        if ($armor === NoArmor::get()) {
            $armor = null;
        }

        // Run tech tests for each component
        if ($platform?->technology() && !$knownTechs->contains($platform->technology())) {
            return false;
        }
        if ($platform?->upgradesTo()?->technology() && $knownTechs->contains($platform->upgradesTo()->technology())) {
            return false;
        }

        if ($equipment?->technology() && !$knownTechs->contains($equipment->technology())) {
            return false;
        }
        if ($equipment?->upgradesTo()?->technology() && $knownTechs->contains($equipment->upgradesTo()->technology())) {
            return false;
        }

        if ($armor?->technology() && !$knownTechs->contains($armor->technology())) {
            return false;
        }
        if ($armor?->upgradesTo()?->technology() && $knownTechs->contains($armor->upgradesTo()->technology())) {
            return false;
        }

        if (!$platform || !$equipment) {
            return true;
        }

        return $platform->canHave($equipment, $armor);
    }

    public function setPlatform(?string $slug): void
    {
        $this->platformSlug = $slug;
    }

    public function setEquipment(?string $slug): void
    {
        $this->equipmentSlug = $slug;
    }

    public function setArmor(?string $slug): void
    {
        $this->armorSlug = $slug;
    }

    public function render(): View
    {
        $this->init();

        // Load Platform data
        $platformItems = collect();
        if (!$this->platform) {
            foreach (UnitPlatformType::all() as $platformItem) {
                if ($this->equipment && !$platformItem->canHave($this->equipment)) {
                    continue;
                }
                $this->setUnitComponentToItems(
                    $platformItems,
                    $platformItem,
                    $this->knownTechs
                );
            }
        }
        if ($platformItems->count() === 1 && $platformItems->first()['items']->count() === 1) {
            $this->platform = $platformItems->first()['items']->first();
        }

        $platformTitle = $this->platform
            ? 'Platform'
            : 'Select Platform';

        // Load Equipment Data
        $equipmentItems = collect();
        if (!$this->equipment) {
            foreach ($this->platform?->equipment() ?: UnitEquipmentType::all() as $equipmentItem) {
                if ($this->platform && !$this->platform->canHave($equipmentItem)) {
                    continue;
                }
                if ($equipmentItem->category() === UnitEquipmentCategory::MassDestruction) {
                    continue;
                }
                $this->setUnitComponentToItems(
                    $equipmentItems,
                    $equipmentItem,
                    $this->knownTechs
                );
            }
        }
        if ($equipmentItems->count() === 1 && $equipmentItems->first()['items']->count() === 1) {
            $this->equipment = $equipmentItems->first()['items']->first();
        }

        $equipmentTitle = match (true) {
            !$this->equipment => 'Select Equipment',
            default => 'Equipment',
        };

        // Load Armor Data
        $armorItems = collect();
        if ($this->platform && $this->equipment?->canHaveArmor() && !$this->armor) {
            foreach ($this->platform->armors() ?: [] as $armorItem) {
                if (!$this->platform->canHave($this->equipment, $armorItem)) {
                    continue;
                }
                $this->setUnitComponentToItems(
                    $armorItems,
                    $armorItem,
                    $this->knownTechs
                );
            }
        }
        if ($armorItems->count() === 1 && $armorItems->first()['items']->count() === 1) {
            $this->armor = $armorItems->first()['items']->first();
        }

        $armorTitle = match (true) {
            !$this->platform => 'To select Armor, select the Platform first',
            $this->platform->armors()->isEmpty() => 'This Platform cannot have Armor',
            !$this->equipment => 'To select Armor, select the Equipment first',
            !$this->equipment->canHaveArmor() => 'This Equipment cannot have Armor',
            !$this->armor => 'Select Armor',
            default => 'Armor',
        };

        // Finally set the name placeholder
        if ($this->platform && $this->equipment) {
            $this->namePlaceholder = UnitName::name(
                $this->platform,
                $this->equipment,
                $this->armor
            );
        }

        return view('livewire.unit-designer', [
            'platform' => $this->platform,
            'platformTitle' => $platformTitle,
            'platformItems' => $platformItems,
            'equipment' => $this->equipment,
            'equipmentTitle' => $equipmentTitle,
            'equipmentItems' => $equipmentItems,
            'armor' => $this->armor,
            'armorTitle' => $armorTitle,
            'armorItems' => $armorItems,
        ]);
    }

    protected function init(): void
    {
        $this->player = Player::firstOrCreate(
            ['user_id' => auth()->id(), 'map_id' => Map::firstOrFail()->id],
            ['color1' => '#009', 'color2' => '#eee']
        );
        $this->knownTechs = TechnologyType::all()
            ->filter(fn(TechnologyType $tech) => $tech->xy()->x < 29)
            ->keyBy(fn(TechnologyType $tech) => $tech->slug());

        $this->platform = $this->platformSlug ? UnitPlatformType::fromSlug($this->platformSlug) : null;

        // Check Platform is known
        if ($this->platform && $this->platform->technology() && !isset($this->knownTechs[$this->platform->technology()->slug()])) {
            $this->platform = null;
            $this->platformSlug = null;
        }

        // Check Platform can have the Equipment
        $this->equipment = $this->equipmentSlug ? UnitEquipmentType::fromSlug($this->equipmentSlug) : null;
        if ($this->platform && $this->equipment && !$this->platform->canHave($this->equipment)) {
            $this->equipmentSlug = null;
            $this->equipment = null;
        }

        // Check can Platform & Equipment have armor
        if ($this->platform && !$this->platform->armorSlots) {
            $this->armorSlug = null;
        }
        if ($this->equipment && !$this->equipment->canHaveArmor()) {
            $this->armorSlug = null;
        }
        $this->armor = $this->armorSlug ? UnitArmorType::fromSlug($this->armorSlug) : null;

        // If the Platform can't support the Armor, unset the armor
        if ($this->platform && $this->armor && !$this->platform->armors()->contains($this->armor)) {
            $this->armorSlug = null;
            $this->armor = null;
        }

        // If the Platform can't support the Equipment & Armor, unset the armor
        if ($this->platform && $this->equipment && $this->armor && !$this->platform->canHave($this->equipment, $this->armor)) {
            $this->armorSlug = null;
            $this->armor = null;
        }

        // Finally set the name placeholder
        if ($this->platform && $this->equipment) {
            $this->namePlaceholder = UnitName::name(
                $this->platform,
                $this->equipment,
                $this->armor
            );
        }
    }

    protected function setUnitComponentToItems(
        Collection                                       $items,
        UnitArmorType|UnitEquipmentType|UnitPlatformType $component,
        Collection                                       $knownTechs
    ): void
    {
        $techSlug = $component->technology()?->slug();
        $upgradesToTechSlug = $component->upgradesTo()?->technology()?->slug();
        if (
            // Required Tech is not known
            ($techSlug && !isset($knownTechs[$techSlug])) ||
            // Already know the tech required for the upgrade
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

    public function save(): void
    {
        $this->init();

        if (!$this->platform || !$this->equipment || !$this->platform->canHave($this->equipment, $this->armor)) {
            throw new BadRequestHttpException(
                'Invalid platform + equipment + armor combination: ' .
                "[$this->platform, $this->equipment, $this->armor]"
            );
        }

        if ($this->player->unitDesigns()->where([
            'platform' => $this->platform,
            'equipment' => $this->equipment,
            'armor' => $this->armor,
        ])->exists()
        ) {
            throw new BadRequestHttpException(
                'Unit Design with platform + equipment + armor combination: ' .
                "[$this->platform, $this->equipment, $this->armor] already exists"
            );
        }

        $this->player->unitDesigns()->create([
            'platform' => $this->platform,
            'equipment' => $this->equipment,
            'armor' => $this->armor,
            'name' => $this->name ?: $this->namePlaceholder,
        ]);
    }
}

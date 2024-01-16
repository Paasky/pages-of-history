<?php

namespace App\Buildings;

use App\AbstractType;
use App\Enums\BuildingCategory;
use App\GameConcept;
use App\Resources\ResourceType;
use Illuminate\Support\Collection;

abstract class BuildingType extends AbstractType
{
    /**
     * @return Collection<int, BuildingType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('Buildings'),
            [BuildingType::class]
        );
    }

    abstract public function category(): BuildingCategory;

    public function icon(): string
    {
        return $this->category()->icon();
    }

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect([
            $this->technology(),
            ... $this->resources()
        ])->filter()->values();
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect();
    }

    abstract public function upgradesTo(): ?BuildingType;
}

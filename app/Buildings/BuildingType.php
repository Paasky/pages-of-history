<?php

namespace App\Buildings;

use App\AbstractType;
use App\Enums\BuildingCategory;
use App\Resources\ResourceType;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
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

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect();
    }

    abstract public function upgradesTo(): ?BuildingType;
}

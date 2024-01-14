<?php

namespace App\Resources;

use App\AbstractType;
use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use Illuminate\Support\Collection;

abstract class ResourceType extends AbstractType
{
    /**
     * @return Collection<int, ResourceType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('Resources'),
            [ResourceType::class]
        );
    }

    abstract public function category(): ResourceCategory;

    abstract public function improvementCategory(): ?ImprovementCategory;
}

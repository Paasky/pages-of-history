<?php

namespace App\Resources;

use App\AbstractType;
use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\GameConcept;
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

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect([$this->technology(), $this->improvementCategory()])->filter();
    }

    abstract public function improvementCategory(): ?ImprovementCategory;
}

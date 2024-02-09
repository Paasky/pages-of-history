<?php

namespace App\Improvements;

use App\AbstractType;
use App\Enums\ImprovementCategory;
use Illuminate\Support\Collection;

abstract class ImprovementType extends AbstractType
{
    /**
     * @return Collection<int, ImprovementType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('Improvements'),
            [ImprovementType::class]
        );
    }

    abstract public function category(): ImprovementCategory;

    public function icon(): string
    {
        return $this->category()->icon();
    }
}

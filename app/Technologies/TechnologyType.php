<?php

namespace App\Technologies;

use App\AbstractType;
use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Enums\YieldType;
use App\GameConcept;
use Illuminate\Support\Collection;

abstract class TechnologyType extends AbstractType
{
    /**
     * @return Collection<int, TechnologyType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('Technologies'),
            [TechnologyType::class, TechTree::class]
        );
    }

    public function category(): ?GameConcept
    {
        return null;
    }

    public function cost(): int
    {
        return round(pow($this->xy()->x, 1.5) * 5 + 10);
    }

    public function order(): int
    {
        return (int)(
            str_pad($this->xy()->x, 3, '0', STR_PAD_LEFT)
            . str_pad($this->xy()->y, 3, '0', STR_PAD_LEFT)
        );
    }

    abstract public function era(): TechnologyEra;

    public function icon(): string
    {
        return YieldType::Science->icon();
    }

    abstract public function xy(): Coordinate;
}

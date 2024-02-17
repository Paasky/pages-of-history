<?php

namespace App\Technologies;

use App\AbstractType;
use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Enums\YieldType;
use App\GameConcept;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

abstract class TechnologyType extends AbstractType
{
    public int $research = 0;

    /**
     * @return Collection<int, TechnologyType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('Technologies'),
            [TechnologyType::class]
        );
    }

    public static function requiredTechs(TechnologyType $for, Collection $knownTechs = null): Collection
    {
        $requiredTechs = collect();
        foreach ($for->requires() as $require) {
            if (!$require instanceof TechnologyType) {
                continue;
            }
            if (isset($knownTechs[$require->slug()])) {
                continue;
            }
            if (isset($requiredTechs[$require->slug()])) {
                continue;
            }
            $requiredTechs[$require->slug()] = $require;
            $requiredTechs = $requiredTechs->merge(
                static::requiredTechs($require, $requiredTechs->merge($knownTechs ?: []))
            );
        }
        return $requiredTechs;
    }

    public function category(): GameConcept
    {
        return $this->era();
    }

    abstract public function era(): TechnologyEra;

    public function icon(): string
    {
        return YieldType::Science->icon();
    }

    public function order(): int
    {
        return (int)(
            str_pad($this->xy()->x, 3, '0', STR_PAD_LEFT)
            . str_pad($this->xy()->y, 3, '0', STR_PAD_LEFT)
        );
    }

    abstract public function xy(): Coordinate;

    public function yieldModifiers(): Collection
    {
        return collect([new YieldModifier(
            $this,
            YieldType::Science,
            $this->cost()
        )]);
    }

    public function cost(): int
    {
        return round(pow($this->xy()->x, 1.5) * 5 + 10);
    }
}

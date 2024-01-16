<?php

namespace App\Enums;

use App\GameConcept;
use App\Resources\ResourceType;
use Illuminate\Support\Collection;

enum ResourceCategory: string implements GameConcept
{
    use GameConceptEnum;

    case Bonus = 'Bonus';
    case Luxury = 'Luxury';
    case Strategic = 'Strategic';
    case Processed = 'Processed';

    public function icon(): string
    {
        return match ($this) {
            self::Bonus => 'fa-circle-plus',
            self::Luxury => YieldType::Luxury->icon(),
            self::Strategic => 'fa-calculator',
            self::Processed => 'fa-gears',
        };
    }

    /**
     * @return Collection<int, GameConcept>
     */
    public function items(): Collection
    {
        return ResourceType::all()->filter(
            fn(ResourceType $type) => $type->category() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'resource';
    }
}

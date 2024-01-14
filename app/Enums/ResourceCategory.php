<?php

namespace App\Enums;

enum ResourceCategory: string
{
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

    public function name(): string
    {
        return $this->name;
    }

    public function shortName(): string
    {
        return $this->name;
    }

    public function typeSlug(): string
    {
        return 'resource';
    }
}

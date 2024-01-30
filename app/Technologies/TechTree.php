<?php

namespace App\Technologies;

use App\Coordinate;
use Illuminate\Support\Collection;

class TechTree
{
    protected static Coordinate $xy;
    public static float $eraTopPadding = 1;
    public static float $eraLeftPadding = 1;
    public static float $techTopPadding = 3;
    public static float $techLeftPadding = 2;
    public static float $techHeight = 6;
    public static float $techHeightGutter = -2;
    public static float $techWidth = 20;
    public static float $techWidthGutter = 3;

    /**
     * @return Collection<int, TechnologyType>
     */
    public static function techs(): Collection
    {
        return TechnologyType::all()->sort(fn(TechnologyType $a, TechnologyType $b) => $a->order() > $b->order());
    }

    public static function xy(): Coordinate
    {
        if (!isset(static::$xy)) {
            static::$xy = new Coordinate(
                static::techs()->max(fn($tech) => $tech->xy()->x),
                static::techs()->max(fn($tech) => $tech->xy()->y)
            );
        }
        return static::$xy;
    }

    public static function eraHeightEm(): float
    {
        return static::xy()->y * (static::$techHeight + static::$techHeightGutter) + abs(static::$techHeightGutter) + static::$techTopPadding + static::$eraTopPadding;
    }

    /**
     * @param Collection<int, TechnologyType> $eraTechs
     * @return float[]
     */
    public static function eraLeftAndWidthEm(Collection $eraTechs): array
    {
        $minX = $eraTechs->min(fn($tech) => $tech->xy()->x);
        $maxX = $eraTechs->max(fn($tech) => $tech->xy()->x);
        return [
            ($minX - 1) * (static::$techWidth + static::$techWidthGutter) + static::$eraTopPadding,
            ($maxX - $minX) * (static::$techWidth + static::$techWidthGutter) + static::$techWidth + static::$eraLeftPadding * 2
        ];
    }

    /**
     * @param Collection<int, TechnologyType> $eraTechs
     * @return int
     */
    public static function eraWidth(Collection $eraTechs): int
    {
        $minX = $eraTechs->min(fn($tech) => $tech->xy()->x);
        $maxX = $eraTechs->max(fn($tech) => $tech->xy()->x);
        return $maxX - $minX + 1;
    }

    public static function heightEm(): float
    {
        return static::xy()->y * (static::$techHeight + static::$techHeightGutter) + static::$techTopPadding * 2 + static::$eraTopPadding * 3;
    }

    public static function widthEm(): float
    {
        return static::xy()->x * (static::$techWidth + static::$techWidthGutter) + static::$eraLeftPadding;
    }

    public static function techLeftEm(TechnologyType $tech): float
    {
        return ($tech->xy()->x - 1) * (static::$techWidth + static::$techWidthGutter) + static::$techLeftPadding;
    }

    public static function techTopEm(TechnologyType $tech): float
    {
        return ($tech->xy()->y - 1) * (static::$techHeight + static::$techHeightGutter) + static::$techTopPadding;
    }
}

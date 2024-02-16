<?php

namespace App\Managers;

class MathManager
{
    public static function getDistance(int $x1, int $y1, int $x2, int $y2): float
    {
        return sqrt(
            pow(max($x1, $x2) - min($x1, $x2), 2) +
            pow(max($y1, $y2) - min($y1, $y2), 2)
        );
    }

    /**
     * Convert given difference percentage into score, eg 0% diff -> +20, 50% diff -> 0, 100% diff -> -20
     * @param int $diffPercent Between 0 (no diff) to 100 (max diff)
     * @param int $scoreMinMax Min/max score to convert to
     * @return int
     * @throws \Exception
     */
    public static function diffPercentToScore(int $diffPercent, int $scoreMinMax): int
    {
        if ($diffPercent < 0 || $diffPercent > 100) {
            throw new \Exception(__FUNCTION__ . " diffPercent $diffPercent must be between 0 and 100.");
        }
        $scoreMinMax = abs($scoreMinMax);
        return (int)round(($diffPercent / 100) * ($scoreMinMax * -2) + $scoreMinMax);
    }
}
